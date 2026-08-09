package handlers

import (
	"fmt"
	"github.com/gin-gonic/gin"
	"net/http"
	"strconv"
	db "ygomp-api/db/sqlc"
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

func GetRandomIds(q *db.Queries) gin.HandlerFunc {
	return func(c *gin.Context) {
		const lowerBound = 1
		const highBound = 100
		limit, err := strconv.Atoi(c.Param("limit"))
		if err != nil {
			c.JSON(http.StatusBadRequest, gin.H{"error": "Invalid limit value"})
			return
		}
		if limit < lowerBound {
			c.JSON(http.StatusBadRequest, gin.H{"error": fmt.Sprintf("Limit value must be at least %v", lowerBound)})
			return
		}
		if limit > highBound {
			c.JSON(http.StatusBadRequest, gin.H{"error": fmt.Sprintf("Limit can't be higher than %v", highBound)})
			return
		}
		ids, err := q.GetRandomCardIds(c.Request.Context(), int32(limit))
		if err != nil {
			c.JSON(http.StatusInternalServerError, gin.H{"error": "Something went wrong please retry later"})
			return
		}
		c.JSON(http.StatusOK, gin.H{"ids": ids})
	}
}
