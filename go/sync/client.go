package sync

import (
	"context"
	"encoding/json"
	"fmt"
	"io"
	"net/http"
	"time"
)

const (
	baseURL    = "https://db.ygoprodeck.com/api/v7"
	versionURL = baseURL + "/checkDBVer.php"
	cardsURL   = baseURL + "/cardinfo.php"
	setsURL    = baseURL + "/cardsets.php"
)

type VersionResponse struct {
	DatabaseVersion string `json:"database_version"`
	LastUpdate      string `json:"last_update"`
}

type CardsResponse struct {
	Data []Card `json:"data"`
}

type Card struct {
	ID                    int32          `json:"id"`
	Name                  string       `json:"name"`
	Type                  string       `json:"type"`
	HumanReadableCardType string       `json:"humanReadableCardType"`
	FrameType             string       `json:"frameType"`
	Desc                  string       `json:"desc"`
	Race                  string       `json:"race"`
	Attribute             string       `json:"attribute,omitempty"`
	Archetype             string       `json:"archetype,omitempty"`
	Atk                   *int16       `json:"atk,omitempty"`
	Def                   *int16       `json:"def,omitempty"`
	Level                 *int16       `json:"level,omitempty"`
	Scale                 *int16       `json:"scale,omitempty"`
	LinkVal               *int16       `json:"linkval,omitempty"`
	LinkMarkers           []string     `json:"linkmarkers,omitempty"`
	CardSets              []CardSetRef `json:"card_sets,omitempty"`
	CardPrices            []CardPrice  `json:"card_prices,omitempty"`
	BanlistInfo           *BanlistInfo `json:"banlist_info,omitempty"`
}

type CardSetRef struct {
	SetName    string `json:"set_name"`
	SetCode    string `json:"set_code"`
	SetRarity  string `json:"set_rarity"`
	SetRarCode string `json:"set_rarity_code"`
	SetPrice   string `json:"set_price"`
}

type CardPrice struct {
	Cardmarket   string `json:"cardmarket_price"`
	TCGPlayer    string `json:"tcgplayer_price"`
	Ebay         string `json:"ebay_price"`
	Amazon       string `json:"amazon_price"`
	CoolStuffInc string `json:"coolstuffinc_price"`
}

type BanlistInfo struct {
	BanTCG  string `json:"ban_tcg,omitempty"`
	BanOCG  string `json:"ban_ocg,omitempty"`
	BanGoat string `json:"ban_goat,omitempty"`
}

type CardSet struct {
	SetName    string `json:"set_name"`
	SetCode    string `json:"set_code"`
	NumOfCards int32  `json:"num_of_cards"`
	TCGDate    string `json:"tcg_date"`
}

func fetchJSON(ctx context.Context, url string, target any) error {
	req, err := http.NewRequestWithContext(ctx, http.MethodGet, url, nil)
	if err != nil {
		return fmt.Errorf("creating request: %w", err)
	}

	client := &http.Client{Timeout: 120 * time.Second}
	resp, err := client.Do(req)
	if err != nil {
		return fmt.Errorf("fetching %s: %w", url, err)
	}
	defer resp.Body.Close()

	body, err := io.ReadAll(resp.Body)
	if err != nil {
		return fmt.Errorf("reading response: %w", err)
	}

	return json.Unmarshal(body, target)
}
