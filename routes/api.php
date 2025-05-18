<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\YgoApiController;
use App\Http\Controllers\Api\CardApiController;
use App\Http\Controllers\Api\OfferApiController;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Api\DeckApiController;
use App\Http\Controllers\Api\ItemApiController;
use App\Http\Controllers\Api\CreditCardApiController;
use App\Http\Controllers\Api\UserApiController;

// YGO API endpoints
Route::get('/card/data', [YgoApiController::class, 'makeRequest'])->name('api.request');
Route::get('/card/images', [YgoApiController::class, 'getImage'])->name('api.image');
Route::get('/card/archetypes', [YgoApiController::class, 'getArchetypes'])->name('api.archetypes');
Route::get('/card/attributes', [YgoApiController::class, 'getAttributes'])->name('api.attributes');
Route::get('/card/types', [YgoApiController::class, 'getTypes'])->name('api.types');
Route::get('/card/races', [YgoApiController::class, 'getRaces'])->name('api.races');

// Card API
Route::prefix('cards')->group(function () {
	Route::post('/', [CardApiController::class, 'create']);
	Route::put('/{card}', [CardApiController::class, 'update']);
	Route::delete('/{card}', [CardApiController::class, 'delete']);
	Route::get('/', [CardApiController::class, 'all']);
	Route::get('/{card}', [CardApiController::class, 'find']);
});

// Offer API
Route::prefix('offers')->group(function () {
	Route::post('/', [OfferApiController::class, 'create']);
	Route::put('/{offer}', [OfferApiController::class, 'update']);
	Route::delete('/{offer}', [OfferApiController::class, 'delete']);
	Route::get('/', [OfferApiController::class, 'all']);
	Route::get('/{offer}', [OfferApiController::class, 'find']);
});

// Order API
Route::prefix('orders')->group(function () {
	Route::post('/', [OrderApiController::class, 'create']);
	Route::put('/{order}', [OrderApiController::class, 'update']);
	Route::delete('/{order}', [OrderApiController::class, 'delete']);
	Route::get('/', [OrderApiController::class, 'all']);
	Route::get('/{order}', [OrderApiController::class, 'find']);
});

// Deck API
Route::prefix('decks')->group(function () {
	Route::post('/', [DeckApiController::class, 'create']);
	Route::put('/{deck}', [DeckApiController::class, 'update']);
	Route::delete('/{deck}', [DeckApiController::class, 'delete']);
	Route::get('/', [DeckApiController::class, 'all']);
	Route::get('/{deck}', [DeckApiController::class, 'find']);
});

// Item API
Route::prefix('items')->group(function () {
	Route::post('/', [ItemApiController::class, 'create']);
	Route::put('/{item}', [ItemApiController::class, 'update']);
	Route::delete('/{item}', [ItemApiController::class, 'delete']);
	Route::get('/', [ItemApiController::class, 'all']);
	Route::get('/{item}', [ItemApiController::class, 'find']);
});

// Credit Card API
Route::prefix('credit-cards')->group(function () {
	Route::post('/', [CreditCardApiController::class, 'create']);
	Route::put('/{credit_card}', [CreditCardApiController::class, 'update']);
	Route::delete('/{credit_card}', [CreditCardApiController::class, 'delete']);
	Route::get('/', [CreditCardApiController::class, 'all']);
	Route::get('/{credit_card}', [CreditCardApiController::class, 'find']);
});

// User API
Route::prefix('users')->group(function () {
	Route::post('/', [UserApiController::class, 'create']);
	Route::put('/{user}', [UserApiController::class, 'update']);
	Route::delete('/{user}', [UserApiController::class, 'delete']);
	Route::get('/', [UserApiController::class, 'all']);
	Route::get('/{user}', [UserApiController::class, 'find']);
});

