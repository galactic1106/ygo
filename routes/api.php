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
Route::post('/cards/', [CardApiController::class, 'create']);
//Route::put('/cards/{card}', [CardApiController::class, 'update']);
//Route::delete('/cards/{card}', [CardApiController::class, 'delete']);
Route::get('/cards', [CardApiController::class, 'all']);
Route::get('/cards/{card}', [CardApiController::class, 'find']);


// Offer API
Route::post('/offers', [OfferApiController::class, 'create']);
Route::put('/offers/{offer}', [OfferApiController::class, 'update']);
Route::delete('/offers/{offer}', [OfferApiController::class, 'delete']);
Route::get('/offers/qualities', [OfferApiController::class, 'getQualities'])->name('api.qualities');
Route::get('/offers', [OfferApiController::class, 'all']);
Route::get('/offers?id={id?}&cardId={cardId?}', [OfferApiController::class, 'find']);


// Order API
Route::post('/orders', [OrderApiController::class, 'create']);
Route::put('/orders/{order}', [OrderApiController::class, 'update']);
Route::delete('/orders/{order}', [OrderApiController::class, 'delete']);
Route::get('/orders', [OrderApiController::class, 'all']);
Route::get('/orders/{order}', [OrderApiController::class, 'find']);


// Deck API
Route::post('/decks', [DeckApiController::class, 'create']);
Route::put('/decks/{deck}', [DeckApiController::class, 'update']);
Route::delete('/decks/{deck}', [DeckApiController::class, 'delete']);
Route::get('/decks', [DeckApiController::class, 'all']);
Route::get('/decks/{deck}', [DeckApiController::class, 'find']);

// Item API
Route::post('/items', [ItemApiController::class, 'create']);
Route::put('/items/{item}', [ItemApiController::class, 'update']);
Route::delete('/items/{item}', [ItemApiController::class, 'delete']);
Route::get('/items', [ItemApiController::class, 'all']);
Route::get('/items/{item}', [ItemApiController::class, 'find']);

// Credit Card API
Route::post('/credit-cards', [CreditCardApiController::class, 'create']);
Route::put('/credit-cards/{credit_card}', [CreditCardApiController::class, 'update']);
Route::delete('/credit-cards/{credit_card}', [CreditCardApiController::class, 'delete']);
Route::get('/credit-cards', [CreditCardApiController::class, 'all']);
Route::get('/credit-cards/{credit_card}', [CreditCardApiController::class, 'find']);

// User API
Route::post('/users', [UserApiController::class, 'create']);
Route::put('/users/{user}', [UserApiController::class, 'update']);
Route::delete('/users/{user}', [UserApiController::class, 'delete']);
Route::get('/users', [UserApiController::class, 'all']);
Route::get('/users/{user}', [UserApiController::class, 'find']);


