<?php
use App\Http\Controllers\Api\YgoApiController;
use Illuminate\Support\Facades\Route;

Route::get('/card/data', [YgoApiController::class, 'makeRequest'])->name('api.request');
Route::get('/card/images', [YgoApiController::class, 'getImage'])->name('api.image');
Route::get('/card/archetypes', [YgoApiController::class, 'getArchetypes'])->name('api.archetypes');
Route::get('/card/attributes', [YgoApiController::class, 'getAttributes'])->name('api.attributes');
Route::get('/card/types', [YgoApiController::class, 'getTypes'])->name('api.types');
Route::get('/card/races', [YgoApiController::class, 'getRaces'])->name('api.races');
