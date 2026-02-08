package handlers

import (
	"net/http"
	db "ygomp-api/db/sqlc"

	"github.com/gin-gonic/gin"
)

func GetDBVersion(q *db.Queries) gin.HandlerFunc {
	return func(c *gin.Context) {

		version, err := q.GetDBVersion(c.Request.Context())
		if err != nil {
			c.JSON(http.StatusInternalServerError, gin.H{
				"error": "failed to get database version",
			})
			return
		}

		c.JSON(http.StatusOK, gin.H{
			"version":      version.Version,
			"last_sync_at": version.LastSyncAt,
		})
	}
}
