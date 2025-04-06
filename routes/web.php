<?php

use App\Http\Controllers\AdminReportController;
use App\Http\Controllers\AdminRestroomController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RestroomController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/restrooms/{restroom}', [RestroomController::class, 'show'])->name('restrooms.show');

Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/edit', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/profile/restrooms', [ProfileController::class, 'restrooms'])->name('profile.restrooms');
    Route::get('/profile/reviews', [ProfileController::class, 'reviews'])->name('profile.reviews');
    Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');

    // Restroom routes
    Route::get('/restrooms/create', [RestroomController::class, 'create'])->name('restrooms.create');
    Route::post('/restrooms', [RestroomController::class, 'store'])->name('restrooms.store');
    Route::post('/restrooms/{restroom}/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    // Report routes
    Route::middleware(['auth'])->post('/reports', [ReportController::class, 'store'])->name('reports.store');
});

Route::middleware(['auth', 'checkUserType:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Restroom routes
        Route::get('/restrooms', [AdminRestroomController::class, 'index'])->name('restrooms.index');
        Route::post('/restrooms/{restroom}/approve', [AdminRestroomController::class, 'approve'])->name('restrooms.approve');
        Route::delete('/restrooms/{restroom}', [AdminRestroomController::class, 'destroy'])->name('restrooms.destroy');

        // Report routes
        Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
        Route::post('/admin/reports/{report}/resolve', [AdminReportController::class, 'resolve'])->name('reports.resolve');

        // Photo routes
        Route::delete('/photos/{photo}', [PhotoController::class, 'destroy'])->middleware(['auth', 'checkUserType:admin'])->name('photos.destroy');
    });

require __DIR__.'/auth.php';
