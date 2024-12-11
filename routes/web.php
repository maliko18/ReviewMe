<?php

use App\Http\Controllers\PlaceController;
use App\Http\Controllers\ReviewController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::prefix('places')->name('places.')->controller(PlaceController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('create', 'create')->name('create');
    Route::post('store', 'store')->name('store');
    Route::get('{place}/edit', 'edit')->name('edit');
    Route::put('{place}', 'update')->name('update');
    Route::delete('{place}', 'destroy')->name('destroy');
    Route::prefix('{place:slug}')->group(function () {
        Route::get('/', 'show')->name('show');
        Route::prefix('reviews')->name('reviews.')->controller(ReviewController::class)->group(function () {
            Route::post('/', 'store')->name('store');
            Route::delete('{review}', 'destroy');
        });
    });
});
Route::get('home', function () {
    return Inertia::render('home');
})->name('home');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/places', function () {
        return Inertia::render('Admin/Places/Index');
    })->name('place.dashboard');
});
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
