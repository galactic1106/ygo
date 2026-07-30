CREATE TABLE users (
    user_id TEXT NOT NULL PRIMARY KEY
);

CREATE TABLE db_version (
    version TEXT NOT NULL PRIMARY KEY,
    last_sync_at timestamp(0) NOT NULL DEFAULT now()
);

-- Lookup: card type from API "type" field (e.g. "Effect Monster", "Spell Card", "XYZ Monster")
CREATE TABLE types (
    type_id SERIAL PRIMARY KEY,
    type TEXT NOT NULL UNIQUE
);

-- Lookup: human-readable type
CREATE TABLE hr_types (
    hr_type_id SERIAL PRIMARY KEY,
    hr_type TEXT NOT NULL UNIQUE
);

-- Lookup: frameType from API (e.g. "normal", "effect", "xyz", "spell", "trap")
CREATE TABLE frames (
    frame_id SERIAL PRIMARY KEY,
    frame TEXT NOT NULL UNIQUE
);

-- Lookup: race from API (e.g. "Warrior", "Spellcaster", "Equip", "Counter")
CREATE TABLE races (
    race_id SERIAL PRIMARY KEY,
    race TEXT NOT NULL UNIQUE
);

-- Lookup: attribute from API (DARK, LIGHT, WATER, FIRE, EARTH, WIND, DIVINE)
CREATE TABLE attributes (
    attribute_id SERIAL PRIMARY KEY,
    attribute TEXT NOT NULL UNIQUE
);

-- Lookup: archetype from API (e.g. "Blue-Eyes", "Dark Magician")
CREATE TABLE archetypes (
    archetype_id SERIAL PRIMARY KEY,
    archetype TEXT NOT NULL UNIQUE
);

-- Lookup: rarity (e.g. "Secret Rare" with code "(ScR)")
CREATE TABLE rarities (
    rarity_id SERIAL PRIMARY KEY,
    rarity TEXT NOT NULL UNIQUE,
    code TEXT NOT NULL
);

-- Lookup: link marker positions (Top, Bottom, Left, Right, Top-Left, Top-Right, Bottom-Left, Bottom-Right)
CREATE TABLE link_markers (
    marker_id SERIAL PRIMARY KEY,
    marker TEXT NOT NULL UNIQUE
);

-- Card sets from the cardsets.php endpoint (set-level data)
-- Note: set_code is NOT unique (e.g. "CT10" can appear for multiple tin waves)
CREATE TABLE card_sets (
    set_id SERIAL PRIMARY KEY,
    name TEXT NOT NULL UNIQUE,
    code TEXT NOT NULL,
    num_of_cards INT,
    tcg_date DATE
);

-- Main cards table
CREATE TABLE cards (
    card_id INT NOT NULL PRIMARY KEY,
    name TEXT NOT NULL,
    type_id INT NOT NULL REFERENCES types(type_id),
    hr_type_id INT NOT NULL REFERENCES hr_types(hr_type_id),
    frame_id INT NOT NULL REFERENCES frames(frame_id),
    description TEXT NOT NULL,
    race_id INT NOT NULL REFERENCES races(race_id),
    attribute_id INT REFERENCES attributes(attribute_id),
    archetype_id INT REFERENCES archetypes(archetype_id),
    atk SMALLINT,
    def SMALLINT,
    level SMALLINT,
    scale SMALLINT,
    linkval SMALLINT,
    cardmarket_price DECIMAL(10,2),
    tcgplayer_price DECIMAL(10,2),
    ebay_price DECIMAL(10,2),
    amazon_price DECIMAL(10,2),
    coolstuffinc_price DECIMAL(10,2),
    last_import_at TIMESTAMP(0) NOT NULL DEFAULT NOW(),
    tcg_date DATE,
    ocg_date DATE
);

-- Banlist info per card (ban_tcg, ban_ocg, ban_goat values: "Banned", "Limited", "Semi-Limited")
CREATE TABLE banlist_info (
    card_id INT PRIMARY KEY REFERENCES cards(card_id),
    ban_tcg TEXT,
    ban_ocg TEXT,
    ban_goat TEXT
);

-- Junction: link markers for Link monsters (one card can have multiple markers)
CREATE TABLE card_link_markers (
    card_id INT NOT NULL REFERENCES cards(card_id),
    marker_id INT NOT NULL REFERENCES link_markers(marker_id),
    PRIMARY KEY (card_id, marker_id)
);

-- Junction: card-in-set entries (from the per-card card_sets array in cardinfo.php)
-- A card can appear in the same set with different rarities (e.g. "JUSH-EN040" as Starlight Rare and Super Rare)
CREATE TABLE card_set_info (
    card_id INT NOT NULL REFERENCES cards(card_id),
    set_id INT NOT NULL REFERENCES card_sets(set_id),
    rarity_id INT NOT NULL REFERENCES rarities(rarity_id),
    price DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (card_id, set_id, rarity_id)
);
