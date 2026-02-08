package sync

import (
	"context"
	"fmt"
	db "ygo-mp/api/db/sqlc"

	"github.com/jackc/pgx/v5/pgtype"
)

func (s *Syncer) importCard(ctx context.Context, qtx *db.Queries, card Card) error {
	typeID, err := qtx.UpsertType(ctx, card.Type)
	if err != nil {
		return fmt.Errorf("upserting type: %w", err)
	}

	hrTypeID, err := qtx.UpsertHrType(ctx, card.HumanReadableCardType)
	if err != nil {
		return fmt.Errorf("upserting hr_type: %w", err)
	}

	frameID, err := qtx.UpsertFrame(ctx, card.FrameType)
	if err != nil {
		return fmt.Errorf("upserting frame: %w", err)
	}

	raceID, err := qtx.UpsertRace(ctx, card.Race)
	if err != nil {
		return fmt.Errorf("upserting race: %w", err)
	}

	var attributeID pgtype.Int4
	if card.Attribute != "" {
		id, err := qtx.UpsertAttribute(ctx, card.Attribute)
		if err != nil {
			return fmt.Errorf("upserting attribute: %w", err)
		}
		attributeID = pgtype.Int4{Int32: id, Valid: true}
	}

	var archetypeID pgtype.Int4
	if card.Archetype != "" {
		id, err := qtx.UpsertArchetype(ctx, card.Archetype)
		if err != nil {
			return fmt.Errorf("upserting archetype: %w", err)
		}
		archetypeID = pgtype.Int4{Int32: id, Valid: true}
	}

	//Parse prices
	var prices CardPrice
	if len(card.CardPrices) > 0 {
		prices = card.CardPrices[0]
	}

	err = qtx.UpsertCard(ctx, db.UpsertCardParams{
		CardID:            int32(card.ID),
		Name:              card.Name,
		TypeID:            typeID,
		HrTypeID:          hrTypeID,
		FrameID:           frameID,
		Description:       card.Desc,
		RaceID:            raceID,
		AttributeID:       attributeID,
		ArchetypeID:       archetypeID,
		Atk:               pgint2(card.Atk),
		Def:               pgint2(card.Def),
		Level:             pgint2(card.Level),
		Scale:             pgint2(card.Scale),
		Linkval:           pgint2(card.LinkVal),
		CardmarketPrice:   pgnum(prices.Cardmarket),
		TcgplayerPrice:    pgnum(prices.TCGPlayer),
		EbayPrice:         pgnum(prices.Ebay),
		AmazonPrice:       pgnum(prices.Amazon),
		CoolstuffincPrice: pgnum(prices.CoolStuffInc),
	})
	if err != nil {
		return fmt.Errorf("upserting card: %w", err)
	}

	if card.BanlistInfo != nil {
		bi := card.BanlistInfo
		err = qtx.UpsertBanlistInfo(ctx, db.UpsertBanlistInfoParams{
			CardID:  int32(card.ID),
			BanTcg:  pgtext(bi.BanTCG),
			BanOcg:  pgtext(bi.BanOCG),
			BanGoat: pgtext(bi.BanGoat),
		})
		if err != nil {
			return fmt.Errorf("upserting banlist: %w", err)
		}
	}

	for _, marker := range card.LinkMarkers {
		markerID, err := qtx.UpsertLinkMarker(ctx, marker)
		if err != nil {
			return fmt.Errorf("upserting link marker: %w", err)
		}
		err = qtx.UpsertCardLinkMarker(ctx, db.UpsertCardLinkMarkerParams{
			CardID:   int32(card.ID),
			MarkerID: markerID,
		})
		if err != nil {
			return fmt.Errorf("upserting card link marker: %w", err)
		}
	}

	for _, cs := range card.CardSets {
		rarityID, err := qtx.UpsertRarity(ctx, db.UpsertRarityParams{
			Rarity: cs.SetRarity,
			Code:   cs.SetRarCode,
		})
		if err != nil {
			return fmt.Errorf("upserting rarity: %w", err)
		}

		setID, err := qtx.UpsertCardSet(ctx, db.UpsertCardSetParams{
			Name: cs.SetName,
			Code: cs.SetCode,
		})
		if err != nil {
			return fmt.Errorf("upserting card set ref: %w", err)
		}

		err = qtx.UpsertCardSetInfo(ctx, db.UpsertCardSetInfoParams{
			CardID:   int32(card.ID),
			SetID:    setID,
			RarityID: rarityID,
			Price:    pgnum(cs.SetPrice),
		})
		if err != nil {
			return fmt.Errorf("upserting card set info: %w", err)
		}
	}

	return nil
}
