-- name: GetRandomCardIds :many
SELECT card_id FROM cards
ORDER BY RANDOM()
LIMIT $1;
