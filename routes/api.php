<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RestroomController;

Route::middleware('throttle:10,1')->group(function () {
    Route::get('/restrooms/nearby', [RestroomController::class, 'nearby']);
});
