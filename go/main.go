package main

import (
	"context"
	"log"
	"time"
	db "ygomp-api/db"
	sqlcdb "ygomp-api/db/sqlc"
	"ygomp-api/routes"
	"ygomp-api/sync"

	"github.com/gin-gonic/gin"
	"golang.org/x/time/rate"
)

const (
	RequestsPerSecond = 18
)

var ip string = "0.0.0.0"
var port string = "8080"

func main() {
	ctx := context.Background()

	if err := db.Migrate(db.MigrateConnString()); err != nil {
		log.Fatalf("Failed to run migrations: %v", err)
	}

	pool := db.Connect(ctx)
	defer pool.Close()

	requestRateLimiter := rate.NewLimiter(rate.Every(time.Second), RequestsPerSecond)
	syncer := sync.New(pool, requestRateLimiter)
	go syncer.StartSchedule(ctx, 20*time.Minute)

	q := sqlcdb.New(pool)

	router := gin.Default()

	routes.Setup(router, q, requestRateLimiter)

	log.Printf("Starting YGO API server on %v:%v\n", ip, port)
	if err := router.Run(":8080"); err != nil {
		log.Fatalf("Failed to start server: %v", err)
	}
}
