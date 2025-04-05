<?php

use App\Http\Controllers\AdminReportController;
use App\Http\Controllers\AdminRestroomController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RestroomController;
use App\Http\Controllers\ReviewController;
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
    Route::get('/restrooms/{restroom}', [RestroomController::class, 'show'])->name('restrooms.show');
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
    });

require __DIR__.'/auth.php';
