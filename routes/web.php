<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/cards', [CardController::class, 'index'])->name('cards.index');
Route::get('/cards/{id}', [CardController::class, 'show'])->name('card.show');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
require __DIR__.'/apiProxy.php';
