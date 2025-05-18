<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use App\Models\Card;
use App\Services\CardService;

class CardServiceProvider extends ServiceProvider
{
	/**
	 * Register services.
	 */
	public function register(): void
	{
		 $this->app->bind(CardService::class, function ($app) {
			return new CardService();
		});
	}

	/**
	 * Bootstrap services.
	 */
	public function boot(): void
	{
		// Log when a Card is created
		Card::created(function ($card) {
			Log::info("Card created: ", ['id' => $card->id, 'name' => $card->name, 'type' => $card->type]);
		});

		// Log when a Card is updated
		Card::updated(function ($card) {
			Log::info("Card updated: ", ['id' => $card->id, 'name' => $card->name, 'type' => $card->type]);
		});

		// Log when a Card is deleted
		Card::deleted(function ($card) {
			Log::info("Card deleted: ", ['id' => $card->id, 'name' => $card->name, 'type' => $card->type]);
		});
		// Log when a Card is retrieved
		Card::retrieved(function ($card) {
			Log::info("Card retrieved: ", ['id' => $card->id, 'name' => $card->name, 'type' => $card->type]);
		});

	}
}