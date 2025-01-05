<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdBanner;
use App\Models\Category;
use App\Models\Country;
use App\Models\Place;
use App\Models\PlaceEvent;
use App\Models\Review;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminDashboardController extends Controller
{
    // AdminDashboardController.php
    public function index()
    {
        $stats = [
            'places_count' => Place::count(),
            'reviews_count' => Review::count(),
            'countries_count' => Country::count(),
            'categories_count' => Category::count(),
            'events_count' => PlaceEvent::count(),
            'banners_count' => AdBanner::count()
        ];

        return Inertia::render('Admin/Index', [
            'stats' => $stats
        ]);
    }
}
