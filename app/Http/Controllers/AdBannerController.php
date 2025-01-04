<?php
// app/Http/Controllers/AdBannerController.php

namespace App\Http\Controllers;

use App\Models\AdBanner;
use App\Models\Place;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class AdBannerController extends Controller
{
    public function index(): Response
    {
        $banners = QueryBuilder::for(AdBanner::class)
            ->allowedFilters([
                AllowedFilter::exact('place_id'),
                AllowedFilter::exact('status'),
                AllowedFilter::callback('search', fn($query, $value) => $query->where('title', 'like', "%{$value}%")
                    ->orWhere('description', 'like', "%{$value}%")
                ),
                AllowedFilter::callback('date', function ($query, $value) {
                    return match ($value) {
                        'active' => $query->where('start_date', '<=', now())
                            ->where('end_date', '>=', now()),
                        'upcoming' => $query->where('start_date', '>', now()),
                        'expired' => $query->where('end_date', '<', now()),
                        default => $query
                    };
                })
            ])
            ->with('place')
            ->latest('start_date')
            ->paginate()
            ->withQueryString();

        return Inertia::render('AdBanners/Index', [
            'banners' => $banners,
            'places' => auth()->user()->can('create ad_banners') ?
                Place::select('id', 'name')->get() : []
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|boolean',
            'place_id' => 'required|exists:places,id',
            'meta' => 'nullable|json'
        ]);

        $place = Place::findOrFail($validated['place_id']);
        $this->authorize('create', [AdBanner::class, $place]);

        AdBanner::create($validated);

        return redirect()->back()
            ->with('success', 'Ad banner created successfully');
    }

    public function update(Request $request, AdBanner $banner)
    {
        $this->authorize('update', $banner);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|boolean',
            'meta' => 'nullable|json'
        ]);

        $banner->update($validated);

        return redirect()->back()
            ->with('success', 'Ad banner updated successfully');
    }

    public function destroy(AdBanner $banner)
    {
        $this->authorize('delete', $banner);

        $banner->delete();

        return redirect()->back()
            ->with('success', 'Ad banner deleted successfully');
    }
}
