# YGO Marketplace

Yu-Gi-Oh! card marketplace platform. Syncs card data from the YGOProDeck API into a PostgreSQL database, serves it via a Go REST API behind an Angie reverse proxy, with a Svelte frontend (planned).

## Tech Stack

- **Language:** Go (Gin HTTP framework)
- **Database:** PostgreSQL 16 (pgx/v5 driver, sqlc for type-safe query generation)
- **Migrations:** golang-migrate (embedded in binary via `//go:embed`, runs on app startup)
- **Reverse Proxy:** Angie (Nginx fork with HTTP/3 & QUIC support)
- **Frontend:** Svelte (not yet implemented — `svelte/` is empty)
- **Orchestration:** Podman Compose (rootless containers)
- **Dev Tooling:** mise (`go`, `sqlc`, `gomigrate`, `podman`)
- **Rate Limiting:** `golang.org/x/time/rate` — shared limiter for all outbound requests to YGOProDeck (sync + on-demand image downloads)

## Project Structure

```
ygo/
├── agents.md                    # AI assistant context (this file)
├── compose.yml                  # Podman Compose (postgres, postgres-auth, api, angie)
├── example.env                  # Template for .env (never commit .env itself)
├── mise.toml                    # mise tool versions
├── .gitignore
├── go/
│   ├── main.go                  # Entry point: migrations → pool → limiter → syncer → routes → Gin
│   ├── go.mod / go.sum          # Module: ygomp-api
│   ├── sqlc.yml                 # sqlc config (pgx/v5, emit JSON tags)
│   ├── Containerfile            # Multi-stage: golang:alpine builder → alpine runtime
│   ├── .containerignore
│   ├── db/
│   │   ├── connection.go        # ConnString(), MigrateConnString(), Connect()
│   │   ├── migrate.go           # Embeds migrations/*.sql, runs golang-migrate on startup
│   │   ├── migrations/          # SQL migration files (up + down)
│   │   │   ├── 000001_init_schema.up.sql
│   │   │   └── 000001_init_schema.down.sql
│   │   ├── queries/             # sqlc query definitions
│   │   │   ├── cards.sql        # UpsertCard, UpsertBanlistInfo, UpsertCardSet, SelectCardById, etc.
│   │   │   ├── lookups.sql      # UpsertType, UpsertRace, UpsertAttribute, etc.
│   │   │   └── version.sql      # GetDBVersion, InsertDBVersion, DeleteDBVersion
│   │   └── sqlc/                # Generated code (DO NOT edit manually)
│   │       ├── db.go
│   │       ├── models.go
│   │       ├── cards.sql.go
│   │       ├── lookups.sql.go
│   │       └── version.sql.go
│   ├── handlers/                # HTTP handler functions (return gin.HandlerFunc)
│   │   ├── cards.go             # GetCard(q) — fetch card by ID
│   │   ├── health.go            # GetDBVersion(q) — database version endpoint
│   │   └── images.go            # GetCardImage/GetSmallImage/GetCroppedImage(limiter) — serve or download images
│   ├── routes/
│   │   └── routes.go            # Setup(router, q, limiter) — registers all route groups
│   ├── sync/
│   │   ├── sync.go              # Syncer struct, StartSchedule(), runSync(), importAll()
│   │   ├── import.go            # importCard() — upserts a single card + relations
│   │   ├── client.go            # FetchJSON(), FetchImage(), API types, URL constants
│   │   └── helpers.go           # pgtext(), pgint2(), pgint4(), pgnum(), fileExists()
│   └── storage/                 # Runtime image cache (volume-mounted, gitignored)
│       └── images/{small,card,cropped}/
├── angie/
│   ├── Containerfile
│   ├── angie.conf               # Main config (workers, gzip, logging)
│   ├── conf.d/default.conf      # Server blocks (SSL, HTTP/3, proxy to api:8080)
│   └── ssl/                     # Self-signed certs (gitignored, generate on host)
│       ├── cert.pem
│       └── key.pem
└── svelte/                      # Frontend (not yet started)
```

## Architecture

### Services (compose.yml)

| Service         | Container Name      | Port              | Purpose                    |
| --------------- | ------------------- | ----------------- | -------------------------- |
| `postgres`      | `ygo-postgres`      | 5432:5432         | Main card database         |
| `postgres-auth` | `ygo-postgres-auth` | 5433:5432         | Auth database (future use) |
| `api`           | `ygo-api`           | 8080 (internal)   | Go API server              |
| `angie`         | `ygo-angie`         | 8080:80, 8443:443 | Reverse proxy (SSL/HTTP3)  |

### Request Flow

```
Client → Angie (:8443 HTTPS/HTTP3) → /ygomp-api/* strips prefix → api:8080 (Gin)
                                    → /health                    → api:8080/health
```

### API Routes

| Method | Path                  | Handler                | Description                           |
| ------ | --------------------- | ---------------------- | ------------------------------------- |
| GET    | `/db-version`         | `GetDBVersion(q)`      | Current database sync version         |
| GET    | `/cards/:id`          | `GetCard(q)`           | Single card by ID                     |
| GET    | `/images/:id/card`    | `GetCardImage(lim)`    | Full card image (cached or download)  |
| GET    | `/images/:id/small`   | `GetSmallImage(lim)`   | Small card image (cached or download) |
| GET    | `/images/:id/cropped` | `GetCroppedImage(lim)` | Cropped card art (cached or download) |

Image endpoints serve from local cache (`storage/images/`) if available, otherwise download from YGOProDeck on-demand via `FetchImage()`, save to disk, then serve.

### Rate Limiting

A single `*rate.Limiter` (18 requests/second) is created in `main.go` and shared between:

- **Syncer** — all `FetchJSON()` calls during background sync
- **Image handlers** — all `FetchImage()` calls for on-demand image downloads

Both `FetchJSON(ctx, limiter, url, target)` and `FetchImage(ctx, limiter, url, dest)` accept the limiter as a parameter and call `limiter.Wait(ctx)` before making the HTTP request. Pass `nil` to skip rate limiting.

### Background Sync

The `Syncer` runs as a goroutine on app startup, then every 20 minutes:

1. Checks `checkDBVer.php` for remote version
2. Compares against `db_version` table
3. If newer: fetches all cards (`cardinfo.php`) and sets (`cardsets.php`)
4. Captures a `syncTimestamp` before the transaction
5. Imports everything in a **single transaction** (upserts to all tables)
6. After commit, queries cards with `last_import_at = syncTimestamp` and deletes their cached images

### Database Schema

- **Lookup tables:** `types`, `hr_types`, `frames`, `races`, `attributes`, `archetypes`, `rarities`, `link_markers`
- **Core tables:** `cards`, `card_sets`, `db_version`, `users`
- **Junction tables:** `card_link_markers`, `card_set_info`, `banlist_info`
- All lookups use `SERIAL PRIMARY KEY` + `UNIQUE` on the value column
- Card IDs are `INT` (YGOProDeck uses 8-digit integers, stored as int32)
- Prices are `DECIMAL(10,2)`
- Nullable fields use `pgtype.*` wrappers (`pgtype.Int2`, `pgtype.Int4`, `pgtype.Text`, `pgtype.Numeric`)

## Development

### Prerequisites

```bash
mise install          # Installs go, sqlc, gomigrate, podman
cp example.env .env   # Fill in credentials
```

### Generate SSL certs (first time)

```bash
mkdir -p angie/ssl
openssl req -x509 -newkey rsa:2048 -nodes \
  -keyout angie/ssl/key.pem \
  -out angie/ssl/cert.pem \
  -days 365 -subj '/CN=localhost'
```

### Build & Run

```bash
podman-compose up --build -d
podman logs -f ygo-api
```

### Rebuild only the API

```bash
podman-compose up --build -d api
```

### Inspect the database

```bash
podman exec -it ygo-postgres psql -U ygouser -d ygodb
```

### After changing SQL queries or schema

```bash
cd go
sqlc generate
go mod tidy
```

Then rebuild the API container.

### After adding a new migration

1. Create `db/migrations/000002_description.up.sql` and `.down.sql`
2. Rebuild and restart — golang-migrate runs automatically on startup
3. Regenerate sqlc if schema changed: `cd go && sqlc generate`

### Reset database from scratch

```bash
podman-compose down
podman volume rm ygo_postgres_data
podman-compose up --build -d
```

### Testing endpoints

```bash
curl -s -k https://localhost:8443/ygomp-api/db-version | jq
curl -s -k https://localhost:8443/ygomp-api/cards/89631139 | jq
curl -s -k https://localhost:8443/ygomp-api/images/89631139/small -o card.jpg
```

## Conventions & Rules

### Go Code

- **Module name:** `ygomp-api`
- **All SQL access goes through sqlc** — no raw SQL in application code
- **Always check errors** — never discard returned errors silently
- **Use `pgtype.*` for nullable columns** — `pgtype.Int2`, `pgtype.Int4`, `pgtype.Text`, `pgtype.Numeric`, `pgtype.Date`, `pgtype.Timestamp`
- **Helper functions** for type conversions live in `sync/helpers.go` — `pgtext()`, `pgint2()`, `pgint4()`, `pgnum()`
- **Transactions:** use `q.WithTx(tx)` to get a transaction-scoped `*db.Queries` (`qtx`), always query through `qtx` within a transaction, never the pool-level `q`
- **Handler pattern:** handlers are functions that return `gin.HandlerFunc` — dependencies (queries, limiter) are passed via closure, not globals
- **Route registration:** all routes defined in `routes/routes.go` via `Setup(router, q, limiter)`
- **Rate limiter:** passed as `*rate.Limiter` to functions that make outbound HTTP requests. Use `nil` if no limiting needed.
- **Log prefix:** sync-related logs use `[sync]` prefix
- **Imports:** use `db "ygomp-api/db"` for connection package, `sqlcdb "ygomp-api/db/sqlc"` for generated queries in main, `db "ygomp-api/db/sqlc"` elsewhere
- **Use `fmt.Sprintf("%d", id)` for int-to-string** — never `string(intVar)` (that produces a Unicode codepoint)
- **Use `filepath.Join` for filesystem paths only** — never for URLs. Concatenate URL strings directly.
- **`filepath.Join` gotcha:** the file extension must be part of the filename string, not a separate argument. `filepath.Join(dir, id+".jpg")` NOT `filepath.Join(dir, id, ".jpg")`
- **Use `%v` in `log.Printf`** — `%w` is only for `fmt.Errorf`

### SQL / Migrations

- Migration files follow `NNNNNN_description.{up,down}.sql` naming
- Migrations are embedded in the Go binary via `//go:embed` in `db/migrate.go`
- The `.containerignore` has `*.sql` excluded BUT `!db/migrations/*.sql` whitelisted so migrations are included in the build context
- Down migrations exist for rollback but are never run automatically
- golang-migrate tracks applied versions in a `schema_migrations` table

### Containers

- Base images use explicit registry: `docker.io/library/golang:alpine`, `docker.io/library/postgres:16-alpine`
- Go binary is statically compiled: `CGO_ENABLED=0 GOOS=linux`
- Runtime image is `alpine:latest` (provides ca-certificates for HTTPS)
- API container working directory: `/root/`
- Image cache volume: `./go/storage:/root/storage`

### Environment

- All credentials live in `.env` (gitignored) — see `example.env` for the template
- DB connection built from: `DB_HOST`, `DB_PORT`, `DB_USER`, `DB_PASSWORD`, `DB_NAME`, `DB_SSLMODE`
- Postgres container picks up: `POSTGRES_USER`, `POSTGRES_PASSWORD`, `POSTGRES_DB`
- Gin mode controlled by `GIN_MODE` (set to `release` in production)

## Data Sources

- **YGOProDeck API v7:** `https://db.ygoprodeck.com/api/v7`
  - `/checkDBVer.php` — database version check
  - `/cardinfo.php` — all card data (returns ~14,000+ cards)
  - `/cardsets.php` — all card set metadata (~1,000+ sets)
- **Card images:** `https://images.ygoprodeck.com/images/cards/`, `cards_small/`, `cards_cropped/`

## Known Constraints

- YGOProDeck API has no delta/incremental endpoint — every sync fetches all data
- Card ATK/DEF/Level/Scale/LinkVal use `SMALLINT` — values are within int16 range
- `card_sets.name` is UNIQUE (used as conflict key), `card_sets.code` is NOT unique
- `rarities.rarity` is UNIQUE, `rarities.code` is NOT unique (different rarities can share codes)
- The sync imports everything in one transaction — if any card fails, the whole batch rolls back
- Rate limiter is shared between sync and image handlers — heavy image traffic can slow down sync and vice versa
