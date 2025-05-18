<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use App\Models\Item;
use App\Services\ItemService;
class ItemServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ItemService::class, function ($app) {
            return new ItemService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Log when an Item is created
        Item::created(function ($item) {
            Log::info("Item created: ", ['id' => $item->id, 'name' => $item->name, 'type' => $item->type]);
        });

        // Log when an Item is updated
        Item::updated(function ($item) {
            Log::info("Item updated: ", ['id' => $item->id, 'name' => $item->name, 'type' => $item->type]);
        });

        // Log when an Item is deleted
        Item::deleted(function ($item) {
            Log::info("Item deleted: ", ['id' => $item->id, 'name' => $item->name, 'type' => $item->type]);
        });
        
        // Log when an Item is retrieved
        Item::retrieved(function ($item) {
            Log::info("Item retrieved: ", ['id' => $item->id, 'name' => $item->name, 'type' => $item->type]);
        });
    }
}
