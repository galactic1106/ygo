<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DeckController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\BrowseController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

Route::get('checkout', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('checkout', [CheckoutController::class, 'process'])->name('checkout.process');

Route::post('/decks/addCard', [DeckController::class, 'addCard'])->name('decks.addCard');
Route::post('/decks/removeCard', [DeckController::class, 'removeCard'])->name('decks.removeCard');
Route::post('/decks/create', [DeckController::class, 'create'])->name('decks.create');
Route::get('/decks', [DeckController::class, 'index'])->name('decks.index');
Route::get('/decks/{id}', [DeckController::class, 'show'])->name('decks.show');
Route::put('/decks/{id}', [DeckController::class, 'update'])->name('decks.update');
Route::delete('/decks/{id}', [DeckController::class, 'delete'])->name('decks.delete');


Route::get('/account', [AccountController::class, 'index'])->name('account.index');
Route::post('/account/update/{id}', [AccountController::class, 'edit'])->name('account.edit');
Route::post('/account/delete/{id}', [AccountController::class, 'destroy'])->name('account.destroy');

Route::get('/order/{id}', [OrderController::class, 'show'])->name('order.show');

Route::post('/offer/{offerId}/change-price', [OfferController::class, 'changePrice'])->name('offer.changePrice');
Route::post('/offer/make', [OfferController::class, 'makeOffer'])->name('offer.make');

Route::get('/card/{id?}', [CardController::class, 'show'])->name('card.show');

Route::get('/browse', [BrowseController::class, 'index'])->name('browse.index');

