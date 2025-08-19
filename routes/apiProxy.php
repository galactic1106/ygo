<?php

use App\Http\Controllers\YapImgRequestController;
use Illuminate\Support\Facades\Route;

Route::get('/yap/raw?url={url}');

Route::get('/yap/img/{size}/{id}',YapImgRequestController::class);