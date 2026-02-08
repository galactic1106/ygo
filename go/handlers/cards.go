package handlers

import (
	"net/http"
	"strconv"
	db "ygomp-api/db/sqlc"

	"github.com/gin-gonic/gin"
)

func GetCard(q *db.Queries) gin.HandlerFunc {
	return func(c *gin.Context) {
		id, err := strconv.Atoi(c.Param("id"))
		if err != nil {
			c.JSON(http.StatusBadRequest, gin.H{
				"error": "Invalid card id",
			})
			return
		}
		card, err := q.SelectCardById(c.Request.Context(), int32(id))
		if err != nil {
			c.JSON(http.StatusNotFound, gin.H{
				"error": "Card not found",
			})
			return
		}

		c.JSON(http.StatusOK, gin.H{
			"card": card,
		})
	}
}
