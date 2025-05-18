<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\CreditCardService;
use Illuminate\Support\Facades\Log;
use App\Models\CreditCard;

class CreditCardServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register the CreditCardService
		$this->app->bind('CreditCardService', function ($app) {
			return new CreditCardService();
		});
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Log when a CreditCard is created
		CreditCard::created(function ($creditCard) {
			\Log::info("CreditCard created: ", ['id' => $creditCard->id, 'card_number' => $creditCard->card_number]);
		});

		// Log when a CreditCard is updated
		CreditCard::updated(function ($creditCard) {
			\Log::info("CreditCard updated: ", ['id' => $creditCard->id, 'card_number' => $creditCard->card_number]);
		});

		// Log when a CreditCard is deleted
		CreditCard::deleted(function ($creditCard) {
			\Log::info("CreditCard deleted: ", ['id' => $creditCard->id, 'card_number' => $creditCard->card_number]);
		});
		// Log when a CreditCard is retrieved
		CreditCard::retrieved(function ($creditCard) {
			\Log::info("CreditCard retrieved: ", ['id' => $creditCard->id, 'card_number' => $creditCard->card_number]);
		});
    }
}