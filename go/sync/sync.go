package sync

import (
	"context"
	"fmt"
	"log"
	"time"
	db "ygo-mp/api/db/sqlc"

	"github.com/jackc/pgx/v5/pgtype"
	"github.com/jackc/pgx/v5/pgxpool"
)

type Syncer struct {
	pool *pgxpool.Pool
	q    *db.Queries
}

func New(pool *pgxpool.Pool) *Syncer {
	return &Syncer{
		pool: pool,
		q:    db.New(pool),
	}
}

func (s *Syncer) StartSchedule(ctx context.Context, interval time.Duration) {
	log.Printf("[sync] Starting sync scheduler (interval: %s)", interval)

	s.runSync(ctx)

	ticker := time.NewTicker(interval)
	defer ticker.Stop()

	for {
		select {
		case <-ticker.C:
			s.runSync(ctx)
		case <-ctx.Done():
			log.Println("[sync] Scheduler stopped")
			return
		}
	}
}

func (s *Syncer) runSync(ctx context.Context) {
	log.Println("[sync] Checking YGOProDeck DB version ...")

	var versions []VersionResponse
	if err := fetchJSON(ctx, versionURL, &versions); err != nil {
		log.Printf("[sync] ERROR fetching remote version: %v", err)
		return
	}
	if len(versions) == 0 {
		log.Printf("[sync] ERROR: empty version response")
		return
	}
	remoteVersion := versions[0].DatabaseVersion

	localVersion, err := s.q.GetDBVersion(ctx)
	if err != nil {
		log.Println("[sync] No local version found, will do initial import")
		localVersion = ""
	}

	if localVersion == remoteVersion {
		log.Printf("[sync] Already up to date (versio %s)", localVersion)
		return
	}

	log.Printf("[sync] Update available: local=%q -> remote %q", localVersion, remoteVersion)

	log.Println("[sync] Fetching all cards from API...")
	var cardsResp CardsResponse
	if err := fetchJSON(ctx, cardsURL, &cardsResp); err != nil {
		log.Printf("[sync] ERROR fetching cards: %v", err)
		return
	}
	log.Printf("[sync] Fetched %d cards", len(cardsResp.Data))

	log.Println("[sync] Fetching all card sets from API...")
	var cardSets []CardSet
	if err := fetchJSON(ctx, setsURL, &cardSets); err != nil {
		log.Printf("[sync] ERROR fetching card sets: %v", err)
		return
	}
	log.Printf("[sync] Fetched %d card sets", len(cardSets))

	if err := s.importAll(ctx, cardsResp.Data, cardSets, remoteVersion); err != nil {
		log.Printf("[sync] ERROR importing data: %v", err)
		return
	}

	log.Printf("[sync] Successfully synced to version %s", remoteVersion)
}

func (s *Syncer) importAll(ctx context.Context, cards []Card, sets []CardSet, version string) error {
	tx, err := s.pool.Begin(ctx)
	if err != nil {
		return fmt.Errorf("[sync] beginning transaction: %w", err)
	}
	defer tx.Rollback(ctx) //no op after commit

	qtx := s.q.WithTx(tx)

	log.Println("[sync] Importing card sets...")
	for _, cs := range sets {
		tcgDate := pgtype.Date{}
		if cs.TCGDate != "" {
			if t, err := time.Parse("2006-01-02", cs.TCGDate); err == nil {
				tcgDate = pgtype.Date{Time: t, Valid: true}
			}
		}
		_, err := qtx.UpsertCardSet(ctx, db.UpsertCardSetParams{
			Name:       cs.SetName,
			Code:       cs.SetCode,
			NumOfCards: pgint4(cs.NumOfCards),
			TcgDate:    tcgDate,
		})
		if err != nil {
			return fmt.Errorf("upserting card set %q: %w", cs.SetName, err)
		}

	}

	log.Println("[sync] Importing cards...")
	for i, card := range cards {
		if err := s.importCard(ctx, qtx, card); err != nil {
			return fmt.Errorf("importing card %d (%s): %w", card.ID, card.Name, err)
		}
		if (i+1)%2000 == 0 {
			log.Printf("[sync] ... %d/%d cards imported", i+1, len(cards))
		}
	}
	qtx.DeleteDBVersion(ctx)
	qtx.InsertDBVersion(ctx, version)

	if err := tx.Commit(ctx); err != nil {
		return fmt.Errorf("committing transaction: %w", err)
	}
	return nil
}
