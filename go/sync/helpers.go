package sync

import (
	"os"

	"github.com/jackc/pgx/v5/pgtype"
)

// pgtext converts a string to a nullable pgtype.Text.
// Empty string → NULL.
func pgtext(s string) pgtype.Text {
	if s == "" {
		return pgtype.Text{}
	}
	return pgtype.Text{String: s, Valid: true}
}

// pgint2 converts an *int to a nullable pgtype.Int2 (SMALLINT).
// nil pointer → NULL.
func pgint2(p *int16) pgtype.Int2 {
	if p == nil {
		return pgtype.Int2{}
	}
	return pgtype.Int2{Int16: int16(*p), Valid: true}
}

func pgint4(n int32) pgtype.Int4 {
	return pgtype.Int4{Int32: int32(n), Valid: true}
}

// pgnum converts a price string like "1.23" to pgtype.Numeric (DECIMAL).
func pgnum(s string) pgtype.Numeric {
	if s == "" {
		return pgtype.Numeric{}
	}
	n := pgtype.Numeric{}
	// pgtype.Numeric can scan from a string
	if err := n.Scan(s); err != nil {
		return pgtype.Numeric{}
	}
	return n
}

func fileExists(path string) bool {
	_, err := os.Stat(path)
	return err == nil
}
