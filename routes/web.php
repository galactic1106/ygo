<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
	return view('home');
})->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/cart', [CartController::class, 'index'])->name('cart');

Route::get('/decks', function () {
	return view('decks');
})->name('decks');

Route::get('/listed_cards', function () {
	return view('listedCards');
})->name('listed_cards');

Route::get('/search', function () {
	return view('search');
})->name('search');


Route::get('/account', [AccountController::class, 'index'])->name('account.index');
Route::post('/account/update/{id}', [AccountController::class, 'edit'])->name('account.edit');
Route::post('/account/delete/{id}', [AccountController::class, 'destroy'])->name('account.destroy');


Auth::routes();

Route::get('/order/{id}', [OrderController::class, 'show'])->name('order.show');


Route::get('/card/{api_id?}', [CardController::class, 'show'])->name('card.show');

Route::get('/test', function (Request $request) {});