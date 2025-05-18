<?php

namespace App\Http\Controllers\Api;
use App\Services\ItemService;
use Illuminate\Support\ServiceProvider;
use App\Models\Item;

class ItemServiceProvider extends ServiceProvider
{
	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(ItemService::class, function ($app) {
			return new ItemService();
		});
	}

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		// Log when an Item is created
		Item::created(function ($item) {
			\Log::info("Item created: ", ['id' => $item->id, 'name' => $item->name]);
		});

		// Log when an Item is updated
		Item::updated(function ($item) {
			\Log::info("Item updated: ", ['id' => $item->id, 'name' => $item->name]);
		});

		// Log when an Item is deleted
		Item::deleted(function ($item) {
			\Log::info("Item deleted: ", ['id' => $item->id, 'name' => $item->name]);
		});

		// Log when an Item is retrieved
		Item::retrieved(function ($item) {
			\Log::info("Item retrieved: ", ['id' => $item->id, 'name' => $item->name]);
		});
	}
}