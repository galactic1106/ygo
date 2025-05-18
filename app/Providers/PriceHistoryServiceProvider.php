<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use App\Models\PriceHistory;
use App\Services\PriceHistoryService;
class PriceHistoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PriceHistoryService::class, function ($app) {
            return new PriceHistoryService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Log when a PriceHistory is created
        PriceHistory::created(function ($priceHistory) {
            Log::info("PriceHistory created: ", ['id' => $priceHistory->id, 'item_id' => $priceHistory->item_id, 'price' => $priceHistory->price]);
        });

        // Log when a PriceHistory is updated
        PriceHistory::updated(function ($priceHistory) {
            Log::info("PriceHistory updated: ", ['id' => $priceHistory->id, 'item_id' => $priceHistory->item_id, 'price' => $priceHistory->price]);
        });
        // Log when a PriceHistory is deleted
        PriceHistory::deleted(function ($priceHistory) {
            Log::info("PriceHistory deleted: ", ['id' => $priceHistory->id, 'item_id' => $priceHistory->item_id, 'price' => $priceHistory->price]);
        });
        // Log when a PriceHistory is retrieved
        PriceHistory::retrieved(function ($priceHistory) {
            Log::info("PriceHistory retrieved: ", ['id' => $priceHistory->id, 'item_id' => $priceHistory->item_id, 'price' => $priceHistory->price]);
        });
    }
}
