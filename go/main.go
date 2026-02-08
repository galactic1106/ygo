package main

import (
	"context"
	"log"
	"net/http"
	"time"
	"ygo-mp/api/db"
	"ygo-mp/api/sync"

	"github.com/gin-gonic/gin"
)

var ip string = "0.0.0.0"
var port string = "8080"

func main() {
	ctx := context.Background()

	pool := db.Connect(ctx)
	defer pool.Close()

	syncer := sync.New(pool)
	go syncer.StartSchedule(ctx, 20*time.Minute)

	router := gin.Default()

	router.GET("/test", func(ctx *gin.Context) {
		ctx.JSON(http.StatusOK, gin.H{
			"data":   "This is a test route",
			"status": "ok",
		})
	})

	log.Printf("Starting YGO API server on %v:%v\n", ip, port)
	if err := router.Run(":8080"); err != nil {
		log.Fatalf("Failed to start server: %v", err)
	}
}
