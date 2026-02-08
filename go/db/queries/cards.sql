-- name: UpsertCard :exec
INSERT INTO cards (
    card_id, name, type_id, hr_type_id, frame_id, description,
    race_id, attribute_id, archetype_id,
    atk, def, level, scale, linkval,
    cardmarket_price, tcgplayer_price, ebay_price, amazon_price, coolstuffinc_price
) VALUES (
    $1, $2, $3, $4, $5, $6,
    $7, $8, $9,
    $10, $11, $12, $13, $14,
    $15, $16, $17, $18, $19
)
ON CONFLICT (card_id) DO UPDATE SET
    name = EXCLUDED.name,
    type_id = EXCLUDED.type_id,
    hr_type_id = EXCLUDED.hr_type_id,
    frame_id = EXCLUDED.frame_id,
    description = EXCLUDED.description,
    race_id = EXCLUDED.race_id,
    attribute_id = EXCLUDED.attribute_id,
    archetype_id = EXCLUDED.archetype_id,
    atk = EXCLUDED.atk,
    def = EXCLUDED.def,
    level = EXCLUDED.level,
    scale = EXCLUDED.scale,
    linkval = EXCLUDED.linkval,
    cardmarket_price = EXCLUDED.cardmarket_price,
    tcgplayer_price = EXCLUDED.tcgplayer_price,
    ebay_price = EXCLUDED.ebay_price,
    amazon_price = EXCLUDED.amazon_price,
    coolstuffinc_price = EXCLUDED.coolstuffinc_price;

-- name: UpsertBanlistInfo :exec
INSERT INTO banlist_info (card_id, ban_tcg, ban_ocg, ban_goat)
VALUES ($1, $2, $3, $4)
ON CONFLICT (card_id) DO UPDATE SET
    ban_tcg = EXCLUDED.ban_tcg,
    ban_ocg = EXCLUDED.ban_ocg,
    ban_goat = EXCLUDED.ban_goat;

-- name: UpsertCardSet :one
INSERT INTO card_sets (name, code, num_of_cards, tcg_date)
VALUES ($1, $2, $3, $4)
ON CONFLICT (name) DO UPDATE SET
    code = EXCLUDED.code,
    num_of_cards = EXCLUDED.num_of_cards,
    tcg_date = EXCLUDED.tcg_date
RETURNING set_id;

-- name: UpsertCardSetInfo :exec
INSERT INTO card_set_info (card_id, set_id, rarity_id, price)
VALUES ($1, $2, $3, $4)
ON CONFLICT (card_id, set_id, rarity_id) DO UPDATE SET
    price = EXCLUDED.price;

-- name: UpsertCardLinkMarker :exec
INSERT INTO card_link_markers (card_id, marker_id)
VALUES ($1, $2)
ON CONFLICT (card_id, marker_id) DO NOTHING;