<?php

use App\Http\Controllers\AccountController;
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

Route::get('/decks', function () {
	return view('decks');
})->name('decks');

Route::get('/account', [AccountController::class, 'index'])->name('account.index');
Route::post('/account/update/{id}', [AccountController::class, 'edit'])->name('account.edit');
Route::post('/account/delete/{id}', [AccountController::class, 'destroy'])->name('account.destroy');

Route::get('/order/{id}', [OrderController::class, 'show'])->name('order.show');

Route::post('/offer/make', [OfferController::class, 'makeOffer'])->name('offer.make');

Route::get('/card/{id?}', [CardController::class, 'show'])->name('card.show');

Route::get('/browse', [BrowseController::class, 'index'])->name('browse.index');

