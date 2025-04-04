<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestroomController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/restrooms/create', [RestroomController::class, 'create'])->name('restrooms.create');
    Route::post('/restrooms', [RestroomController::class, 'store'])->name('restrooms.store');
});

require __DIR__.'/auth.php';
