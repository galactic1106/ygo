package routes

import (
	db "ygomp-api/db/sqlc"
	"ygomp-api/handlers"

	"github.com/gin-gonic/gin"
	"golang.org/x/time/rate"
)

func Setup(router *gin.Engine, q *db.Queries, limiter *rate.Limiter) {

	router.GET("/db-version", handlers.GetDBVersion(q))

	cardGroup := router.Group("/cards")
	{
		cardGroup.GET("/:id", handlers.GetCard(q))
		cardGroup.GET("/random/id/:limit", handlers.GetRandomIds(q))
	}

	imageGroup := router.Group("/images/:id")
	{
		imageGroup.GET("/card", handlers.GetCardImage(limiter))
		imageGroup.GET("/cropped", handlers.GetCroppedImage(limiter))
		imageGroup.GET("/small", handlers.GetSmallImage(limiter))
	}
}
