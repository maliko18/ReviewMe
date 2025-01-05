<?php


use App\Http\Controllers\{AdBannerController,
    AdminDashboardController,
    AdminPlaceController,
    AdminPlaceEventController,
    CategoryController,
    DashboardController,
    PlaceController,
    ReviewController};
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::prefix('places')->name('places.')->controller(AdminPlaceController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::middleware(['can:create places'])->group(function () {
                Route::get('/create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
            });
            Route::get('/{place}', 'show')->name('show');
            Route::middleware(['check.place.admin'])->group(function () {
                Route::get('/{place}/edit', 'edit')->name('edit');
                Route::put('/{place}', 'update')->name('update');
                Route::delete('/{place}', 'destroy')->name('destroy');
                Route::get('/{place}/analytics', 'analytics')
                    ->name('analytics');
            });
        });

        // Reviews Routes
        Route::prefix('reviews')->name('reviews.')->controller(ReviewController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::middleware(['can:create reviews'])->group(function () {
                Route::get('/create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
            });

            Route::middleware(['can:edit reviews'])->group(function () {
                Route::get('/{review}/edit', 'edit')->name('edit');
                Route::put('/{review}', 'update')->name('update');
            });

            Route::delete('/{review}', 'destroy')
                ->middleware('can:delete reviews')
                ->name('reviews.destroy');
        });

        // Events Routes
        Route::prefix('events')->name('events.')->middleware('can:manage events')->controller(AdminPlaceEventController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::prefix('/{event}')->group(function () {
                Route::get('/', 'show')->name('show');
                Route::get('/edit', 'edit')->name('edit');
                Route::post('/', 'update')->name('update');
                Route::delete('/', 'destroy')->name('destroy');
            });
        });

        Route::middleware(['can:manage categories'])->group(function () {
            Route::resource('categories', CategoryController::class);
        });
        Route::resource('banners', AdBannerController::class);
        Route::prefix('banners')->name('banners.')->controller(AdBannerController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::middleware(['can:manage banners'])->group(function () {
                Route::get('/create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::get('/{banner}/edit', 'edit')->name('edit');
                Route::put('/{banner}', 'update')->name('update');
                Route::delete('/{banner}', 'destroy')->name('destroy');
            });
        });
    });
});
Route::prefix('places')->name('places.')->controller(PlaceController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/', 'store')->name('store');
    Route::prefix('/{place}')->group(function () {
        Route::get('/', 'show')->name('show');
        Route::get('/edit', 'edit')->name('edit');
        Route::put('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('destroy');
        Route::prefix('reviews')->name('reviews.')->controller(ReviewController::class)->group(function () {
            Route::post('/', 'store')->name('store');
            Route::delete('{review}', 'destroy');
        });
    });
});
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'phpVersion' => PHP_VERSION,
    ]);
});
/*
use App\Http\Controllers\CategoryController;
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

Route::prefix('categories')->name('categories.')->controller(CategoryController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/', 'store')->name('store');
    Route::put('{category}', 'update')->name('update');
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
*/
