<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RestroomController;

Route::get('/restrooms/nearby', [RestroomController::class, 'nearby']);