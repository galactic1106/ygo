package db

import (
	"context"
	"fmt"
	"log"
	"os"
	"strings"

	"github.com/jackc/pgx/v5/pgxpool"
)

// ConnString builds the PostgreSQL connection string from environment variables.
func ConnString() string {
	return fmt.Sprintf(
		"postgres://%s:%s@%s:%s/%s?sslmode=%s",
		getEnv("DB_USER", "ygouser"),
		getEnv("DB_PASSWORD", "ygopassword"),
		getEnv("DB_HOST", "localhost"),
		getEnv("DB_PORT", "5432"),
		getEnv("DB_NAME", "ygodb"),
		getEnv("DB_SSLMODE", "disable"),
	)
}

// MigrateConnString returns the connection string with the pgx5:// scheme
// required by golang-migrate's pgx/v5 driver.
func MigrateConnString() string {
	return strings.Replace(ConnString(), "postgres://", "pgx5://", 1)
}

// Connect creates a PostgreSQL connection pool from environment variables.
// A pool manages multiple connections so the app can handle concurrent queries.
func Connect(ctx context.Context) *pgxpool.Pool {
	pool, err := pgxpool.New(ctx, ConnString())
	if err != nil {
		log.Fatalf("Unable to connect to database: %v", err)
	}

	log.Println("Connected to PostgreSQL")
	return pool
}

func getEnv(key, fallback string) string {
	if val, ok := os.LookupEnv(key); ok {
		return val
	}
	return fallback
}
