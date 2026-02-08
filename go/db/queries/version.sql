-- name: GetDBVersion :one
SELECT version FROM db_version LIMIT 1;

-- name: DeleteDBVersion :exec
DELETE FROM db_version;

-- name: InsertDBVersion :exec
INSERT INTO db_version (version) VALUES ($1);
