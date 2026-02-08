package sync

import (
	"context"
	"fmt"
	"log"
	"os"
	"path/filepath"
	"time"
	db "ygomp-api/db/sqlc"

	"golang.org/x/time/rate"

	"github.com/jackc/pgx/v5/pgtype"
	"github.com/jackc/pgx/v5/pgxpool"
)

type Syncer struct {
	pool    *pgxpool.Pool
	q       *db.Queries
	limiter *rate.Limiter
}

func New(pool *pgxpool.Pool, limiter *rate.Limiter) *Syncer {
	return &Syncer{
		pool:    pool,
		q:       db.New(pool),
		limiter: limiter,
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
	if err := FetchJSON(ctx, s.limiter, VersionURL, &versions); err != nil {
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
		localVersion.Version = ""
	}

	if localVersion.Version == remoteVersion {
		log.Printf("[sync] Already up to date (version %s)", localVersion.Version)
		return
	}

	log.Printf("[sync] Update available: local=%q -> remote %q", localVersion.Version, remoteVersion)

	log.Println("[sync] Fetching all cards from API...")
	var cardsResp CardsResponse
	if err := FetchJSON(ctx, s.limiter, CardsURL, &cardsResp); err != nil {
		log.Printf("[sync] ERROR fetching cards: %v", err)
		return
	}
	log.Printf("[sync] Fetched %d cards", len(cardsResp.Data))

	log.Println("[sync] Fetching all card sets from API...")
	var cardSets []CardSet
	if err := FetchJSON(ctx, s.limiter, SetsURL, &cardSets); err != nil {
		log.Printf("[sync] ERROR fetching card sets: %v", err)
		return
	}
	log.Printf("[sync] Fetched %d card sets", len(cardSets))

	syncTimestamp := pgtype.Timestamp{Time: time.Now(), Valid: true}

	if err := s.importAll(ctx, cardsResp.Data, cardSets, remoteVersion, syncTimestamp); err != nil {
		log.Printf("[sync] ERROR importing data: %v", err)
		return
	}

	log.Println("[sync] Deleting possibly outdated images")

	updatedCardsIds, err := s.q.SelectUpdatedCardsIds(ctx, syncTimestamp)
	if err != nil {
		log.Printf("[sync] ERROR selecting updated card ids: %v", err)
		return
	}

	for _, id := range updatedCardsIds {
		idStr := fmt.Sprintf("%d.jpg", id)

		path := filepath.Join("./storage/images/small/", idStr)
		if fileExists(path) {
			if err := os.Remove(path); err != nil {
				log.Printf("[sync] ERROR removing: %s", path)
				return
			}
		}

		path = filepath.Join("./storage/images/card/", idStr)
		if fileExists(path) {
			if err := os.Remove(path); err != nil {
				log.Printf("[sync] ERROR removing: %s", path)
				return
			}
		}

		path = filepath.Join("./storage/images/cropped/", idStr)
		if fileExists(path) {
			if err := os.Remove(path); err != nil {
				log.Printf("[sync] ERROR removing: %s", path)
				return
			}
		}
	}
	log.Printf("[sync] Successfully removed possibly outdated images")

	log.Printf("[sync] Successfully synced to version %s", remoteVersion)
}

func (s *Syncer) importAll(ctx context.Context, cards []Card, sets []CardSet, version string, syncTimestamp pgtype.Timestamp) error {
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

	// need to be before importCard()
	if err := qtx.DeleteDBVersion(ctx); err != nil {
		return fmt.Errorf("deleting DB version: %w", err)
	}
	if err := qtx.InsertDBVersion(ctx, version); err != nil {
		return fmt.Errorf("inserting DB version: %w", err)
	}

	log.Println("[sync] Importing cards...")
	for i, card := range cards {
		if err := s.importCard(ctx, qtx, card, syncTimestamp); err != nil {
			return fmt.Errorf("importing card %d (%s): %w", card.ID, card.Name, err)
		}
		if (i+1)%2000 == 0 {
			log.Printf("[sync] ... %d/%d cards imported", i+1, len(cards))
		}
	}

	if err := tx.Commit(ctx); err != nil {
		return fmt.Errorf("committing transaction: %w", err)
	}
	return nil
}
