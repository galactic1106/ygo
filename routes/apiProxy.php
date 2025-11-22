<?php

use App\Http\Controllers\YapImgRequestController;
use App\Http\Controllers\YapRawRequestController;
use App\Http\Controllers\YapRequestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\YapArchetypesController;
use App\Http\Controllers\YapAttributesController;
use App\Http\Controllers\YapFormatsController;
use App\Http\Controllers\YapFrameTypesController;
use App\Http\Controllers\YapLinkMarkersController;
use App\Http\Controllers\YapRacesController;
use App\Http\Controllers\YapTypesController;

Route::get('/yap', YapRequestController::class);
Route::get('/yap/raw?url={url}', YapRawRequestController::class);
Route::get('/yap/img/{size}/{id}', YapImgRequestController::class);
Route::get('/yap/races', YapRacesController::class);
Route::get('/yap/types', YapTypesController::class);
Route::get('/yap/frame-types', YapFrameTypesController::class);
Route::get('/yap/archetypes', YapArchetypesController::class);
Route::get('/yap/attributes', YapAttributesController::class);
Route::get('/yap/link-markers', YapLinkMarkersController::class);
Route::get('/yap/formats', YapFormatsController::class);
