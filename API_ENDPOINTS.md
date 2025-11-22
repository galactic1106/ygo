# YGO API Proxy Endpoints

This document lists all available API endpoints for the YGO Proxy service.

## Card Data Endpoints

### Get Card Data
```
GET /yap
```
Query parameters: See CardDataRequest validation rules

### Get Raw Card Data
```
GET /yap/raw?url={url}
```
- `url`: Full URL to the YGO API endpoint

### Get Card Image
```
GET /yap/img/{size}/{id}
```
- `size`: `card`, `small`, or `cropped`
- `id`: Card ID

## Filter Options Endpoints

### Get Races
```
GET /yap/races?type={cardType}
```
**Query Parameters:**
- `type` (optional): `all`, `monster`, `spell`, or `trap` (default: `all`)

**Example Response:**
```json
[
  "Aqua",
  "Beast",
  "Dragon",
  "Spellcaster",
  ...
]
```

### Get Types
```
GET /yap/types?type={cardType}
```
**Query Parameters:**
- `type` (optional): `all`, `main`, `main monsters`, `extra`, `other`, `spells`, or `traps` (default: `all`)

**Example Response:**
```json
[
  "Effect Monster",
  "Fusion Monster",
  "Synchro Monster",
  "XYZ Monster",
  ...
]
```

### Get Frame Types
```
GET /yap/frame-types
```
**Example Response:**
```json
[
  "normal",
  "effect",
  "ritual",
  "fusion",
  "synchro",
  "xyz",
  "link",
  ...
]
```

### Get Archetypes
```
GET /yap/archetypes
```
Fetches all available archetypes from the YGO API (cached for 24 hours).

**Example Response:**
```json
[
  "Blue-Eyes",
  "Dark Magician",
  "Elemental HERO",
  ...
]
```

### Get Attributes
```
GET /yap/attributes
```
**Example Response:**
```json
[
  "dark",
  "light",
  "earth",
  "water",
  "fire",
  "wind",
  "divine"
]
```

### Get Link Markers
```
GET /yap/link-markers
```
**Example Response:**
```json
[
  "top",
  "bottom",
  "left",
  "right",
  "bottom-left",
  "bottom-right",
  "top-left",
  "top-right"
]
```

### Get Formats
```
GET /yap/formats
```
**Example Response:**
```json
[
  "tcg",
  "goat",
  "ocg goat",
  "speed duel",
  "master duel",
  "rush duel",
  "duel links"
]
```

## Usage Notes

- All endpoints return JSON responses
- The archetypes endpoint makes an external API call and is cached for 24 hours
- Rate limiting is applied to external API calls (18 requests per second)
- Most filter option endpoints return static arrays and are very fast
