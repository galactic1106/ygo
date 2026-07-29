package sync

import (
	"context"
	"encoding/json"
	"fmt"
	"io"
	"net/http"
	"os"
	"path/filepath"
	"time"

	"golang.org/x/time/rate"
)

const (
	BaseURL         = "https://db.ygoprodeck.com/api/v7"
	VersionURL      = BaseURL + "/checkDBVer.php"
	CardsURL        = BaseURL + "/cardinfo.php?misc=1"
	SetsURL         = BaseURL + "/cardsets.php"
	BaseImageURL    = "https://images.ygoprodeck.com/images"
	SmallImageURL   = BaseImageURL + "/cards_small/"
	CardImageURL    = BaseImageURL + "/cards/"
	CroppedImageURL = BaseImageURL + "/cards_cropped/"
)

type VersionResponse struct {
	DatabaseVersion string `json:"database_version"`
	LastUpdate      string `json:"last_update"`
}

type CardsResponse struct {
	Data []Card `json:"data"`
}
/*
beta_name
views
viewsweek
upvotes
downvotes
formats
tcg_date
ocg_date
konami_id
has_effect
md_rarity
*/

type MiscInfo struct {
	BetaName  string   `json:"beta_name,omitempty"`
	Views     int32    `json:"views,omitempty"`
	Viewsweek int32    `json:"viewsweek,omitempty"`
	Upvotes   int32    `json:"upvotes,omitempty"`
	Downvotes int32    `json:"downvotes,omitempty"`
	Formats   []string `json:"formats,omitempty"`
	TcgDate   string   `json:"tcg_date,omitempty"`
	OcgDate   string   `json:"ocg_date,omitempty"`
	KonamiId  int32    `json:"konami_id,omitempty"`
	HasEffect int32    `json:"has_effect,omitempty"`
	MdRarity  string   `json:"md_rarity,omitempty"`
}

type Card struct {
	ID                    int32        `json:"id"`
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
	MiscInfo              []MiscInfo   `json:"misc_info,omitempty"`
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

func FetchJSON(ctx context.Context, limiter *rate.Limiter, url string, target any) error {
	if limiter != nil {
		if err := limiter.Wait(ctx); err != nil {
			return fmt.Errorf("rate limit wait: %w", err)
		}
	}

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

func FetchImage(ctx context.Context, limiter *rate.Limiter, url string, dest string) error {
	if limiter != nil {
		if err := limiter.Wait(ctx); err != nil {
			return fmt.Errorf("rate limit wait: %w", err)
		}
	}

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

	if resp.StatusCode != http.StatusOK {
		return fmt.Errorf("bad status: %s", resp.Status)
	}

	dir := filepath.Dir(dest)
	if err := os.MkdirAll(dir, 0755); err != nil {
		return fmt.Errorf("creating directory: %w", err)
	}

	file, err := os.Create(dest)
	if err != nil {
		return fmt.Errorf("creating file: %w", err)
	}
	defer file.Close()

	_, err = io.Copy(file, resp.Body)
	if err != nil {
		return fmt.Errorf("writing image: %w", err)
	}

	return nil
}
