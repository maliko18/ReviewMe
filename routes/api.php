<?php

use App\Http\Controllers\PlaceController;
use App\Http\Controllers\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController;


/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');*/

Route::prefix('places')->name('places.')->controller(PlaceController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/', 'store')->name('store');

    Route::prefix('/{place}')->group(function () {
        Route::get('/', 'show');
        Route::put('/', 'update');
        Route::delete('/', 'destroy');
        Route::post('/reviews', [ReviewController::class,'store']);
    });


});

Route::prefix('reviews')->name('reviews')->controller(ReviewController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/{review}', 'show');
    Route::put('/{review}', 'update');
    Route::delete('/{review}', 'destroy');
});

Route::get('/countries', [CountryController::class, 'index']);
