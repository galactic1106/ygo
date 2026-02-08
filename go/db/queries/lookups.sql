-- name: UpsertType :one
INSERT INTO types (type) VALUES ($1)
ON CONFLICT (type) DO UPDATE SET type=EXCLUDED.type
RETURNING type_id;

-- name: UpsertHrType :one
INSERT INTO hr_types (hr_type) VALUES ($1)
ON CONFLICT (hr_type) DO UPDATE SET hr_type = EXCLUDED.hr_type
RETURNING hr_type_id;

-- name: UpsertFrame :one
INSERT INTO frames (frame) VALUES ($1)
ON CONFLICT (frame) DO UPDATE SET frame = EXCLUDED.frame
RETURNING frame_id;

-- name: UpsertRace :one
INSERT INTO races (race) VALUES ($1)
ON CONFLICT (race) DO UPDATE SET race = EXCLUDED.race
RETURNING race_id;

-- name: UpsertAttribute :one
INSERT INTO attributes (attribute) VALUES ($1)
ON CONFLICT (attribute) DO UPDATE SET attribute = EXCLUDED.attribute
RETURNING attribute_id;

-- name: UpsertArchetype :one
INSERT INTO archetypes (archetype) VALUES ($1)
ON CONFLICT (archetype) DO UPDATE SET archetype = EXCLUDED.archetype
RETURNING archetype_id;

-- name: UpsertRarity :one
INSERT INTO rarities (rarity, code) VALUES ($1, $2)
ON CONFLICT (rarity) DO UPDATE SET code = EXCLUDED.code
RETURNING rarity_id;

-- name: UpsertLinkMarker :one
INSERT INTO link_markers (marker) VALUES ($1)
ON CONFLICT (marker) DO UPDATE SET marker = EXCLUDED.marker
RETURNING marker_id;
