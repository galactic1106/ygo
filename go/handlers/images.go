package handlers

import (
	"log"
	"net/http"
	"os"
	"path/filepath"
	"strconv"
	"ygomp-api/sync"

	"github.com/gin-gonic/gin"
	"golang.org/x/time/rate"
)

const (
	ImagePath        = "./storage/images/"
	CardImagePath    = ImagePath + "card/"
	SmallImagePath   = ImagePath + "small/"
	CroppedImagePath = ImagePath + "cropped/"
)

func GetCardImage(limiter *rate.Limiter) gin.HandlerFunc {
	return func(ctx *gin.Context) {
		_, err := strconv.Atoi(ctx.Param("id"))
		if err != nil {
			ctx.JSON(http.StatusBadRequest, gin.H{
				"error": "Invalid card id",
			})
			return
		}

		imageFilePath := filepath.Join(CardImagePath, ctx.Param("id")+".jpg")
		if _, err := os.Stat(imageFilePath); err == nil {
			ctx.File(imageFilePath)
			return
		}

		imageURL := sync.CardImageURL + ctx.Param("id") + ".jpg"
		if err := sync.FetchImage(ctx.Request.Context(), limiter, imageURL, imageFilePath); err != nil {
			log.Printf("error fetching %v", err)
			ctx.JSON(http.StatusNotFound, gin.H{
				"error": "Image not found",
			})
			return
		}

		ctx.File(imageFilePath)
	}
}

func GetSmallImage(limiter *rate.Limiter) gin.HandlerFunc {
	return func(ctx *gin.Context) {
		_, err := strconv.Atoi(ctx.Param("id"))
		if err != nil {
			ctx.JSON(http.StatusBadRequest, gin.H{
				"error": "Invalid card id",
			})
			return
		}

		imageFilePath := filepath.Join(SmallImagePath, ctx.Param("id")+".jpg")
		if _, err := os.Stat(imageFilePath); err == nil {
			ctx.File(imageFilePath)
			return
		}

		imageURL := sync.SmallImageURL + ctx.Param("id") + ".jpg"
		if err := sync.FetchImage(ctx.Request.Context(), limiter, imageURL, imageFilePath); err != nil {
			log.Printf("error fetching %v", err)
			ctx.JSON(http.StatusNotFound, gin.H{
				"error": "Image not found",
			})
			return
		}

		ctx.File(imageFilePath)
	}
}

func GetCroppedImage(limiter *rate.Limiter) gin.HandlerFunc {
	return func(ctx *gin.Context) {
		_, err := strconv.Atoi(ctx.Param("id"))
		if err != nil {
			ctx.JSON(http.StatusBadRequest, gin.H{
				"error": "Invalid card id",
			})
			return
		}

		imageFilePath := filepath.Join(CroppedImagePath, ctx.Param("id")+".jpg")
		if _, err := os.Stat(imageFilePath); err == nil {
			ctx.File(imageFilePath)
			return
		}

		imageURL := sync.CroppedImageURL + ctx.Param("id") + ".jpg"
		if err := sync.FetchImage(ctx.Request.Context(), limiter, imageURL, imageFilePath); err != nil {
			log.Printf("error fetching %v", err)
			ctx.JSON(http.StatusNotFound, gin.H{
				"error": "Image not found",
			})
			return
		}

		ctx.File(imageFilePath)
	}
}
