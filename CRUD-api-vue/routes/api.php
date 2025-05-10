<?php

use App\Http\Controllers\MakananController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::resource('/posts', PostController::class)->middleware('cors');
Route::resource('/makanan', MakananController::class)->middleware('cors');

