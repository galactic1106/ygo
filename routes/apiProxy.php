<?php

use App\Http\Controllers\YapImgRequestController;
use App\Http\Controllers\YapRawRequestController;
use App\Http\Controllers\YapRequestController;
use Illuminate\Support\Facades\Route;

Route::get('/yap', YapRequestController::class);
Route::get('/yap/raw?url={url}', YapRawRequestController::class);
Route::get('/yap/img/{size}/{id}', YapImgRequestController::class);
