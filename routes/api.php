<?php

use App\Http\Controllers\AdBannerController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\PlaceEventController;


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
        Route::prefix('/ad-banners')->controller(AdBannerController::class)->group(function () {
            Route::get('/', 'index');
            Route::post('/', 'store');
        });
        Route::post('/place-events', [PlaceEventController::class,'store']);
    });


});

Route::prefix('reviews')->name('reviews')->controller(ReviewController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/{review}', 'show');
    Route::put('/{review}', 'update');
    Route::delete('/{review}', 'destroy');
});

Route::prefix('ad-banners')->name('ad-banners')->controller(AdBannerController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/{ad-banner}', 'show');
    Route::put('/{ad-banner}', 'update');
    Route::delete('/{ad-banner}', 'destroy');
});

Route::get('/countries', [CountryController::class, 'index']);
Route::get('countries/{country}/cities', [CityController::class, 'index']);
Route::prefix('categories')->controller(CategoryController::class)->group(function () {
    Route::get('/',  'index'); // Liste des catégories
    Route::post('/',  'store'); // Créer une catégorie ou sous-catégorie
    Route::delete('/{category}', 'destroy');

});

 Route::prefix('place-events')->name('place-events.')->controller(PlaceEventController::class)->group(function () {
     Route::get('/',  'index');
     Route::put('/{placeEvent}', 'update');
     Route::delete('/{placeEvent}', 'destroy');
     Route::get('/{placeEvent}', 'show');
 });




