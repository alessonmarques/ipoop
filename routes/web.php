<?php

use App\Http\Controllers\AdminRestroomController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestroomController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Restroom routes
    Route::get('/restrooms/create', [RestroomController::class, 'create'])->name('restrooms.create');
    Route::post('/restrooms', [RestroomController::class, 'store'])->name('restrooms.store');
});


Route::middleware(['auth', 'checkUserType:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/restrooms', [AdminRestroomController::class, 'index'])->name('restrooms.index');
        Route::post('/restrooms/{restroom}/approve', [AdminRestroomController::class, 'approve'])->name('restrooms.approve');
        Route::delete('/restrooms/{restroom}', [AdminRestroomController::class, 'destroy'])->name('restrooms.destroy');

        Route::get('/restrooms/{restroom}', [AdminRestroomController::class, 'show'])->name('restrooms.show');
    });

require __DIR__.'/auth.php';
