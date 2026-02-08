-- name: GetDBVersion :one
SELECT version, last_sync_at FROM db_version LIMIT 1;

-- name: DeleteDBVersion :exec
DELETE FROM db_version;

-- name: InsertDBVersion :exec
INSERT INTO db_version (version,last_sync_at) VALUES ($1,now());
