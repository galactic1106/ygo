<?php
use App\Http\Controllers\Api\YgoApiController;
use Illuminate\Support\Facades\Route;

Route::get('/card/data', [YgoApiController::class, 'makeRequest'])->name('api.request');
Route::get('/card/images', [YgoApiController::class, 'getImage'])->name('api.image');
