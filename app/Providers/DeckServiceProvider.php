<?php

namespace App\Providers;
use App\Models\Deck;
use App\Services\DeckService;
use Illuminate\Support\ServiceProvider;

class DeckServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(DeckService::class, function ($app) {
			return new DeckService();
		});
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Log when a Deck is created
        Deck::created(function ($deck) {
            \Log::info("Deck created: ", ['id' => $deck->id, 'name' => $deck->name]);
        });

        // Log when a Deck is updated
        Deck::updated(function ($deck) {
            \Log::info("Deck updated: ", ['id' => $deck->id, 'name' => $deck->name]);
        });

        // Log when a Deck is deleted
        Deck::deleted(function ($deck) {
            \Log::info("Deck deleted: ", ['id' => $deck->id, 'name' => $deck->name]);
        });
        
        // Log when a Deck is retrieved
        Deck::retrieved(function ($deck) {
            \Log::info("Deck retrieved: ", ['id' => $deck->id, 'name' => $deck->name]);
        });
    }
}
