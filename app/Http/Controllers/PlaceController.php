<?php

namespace App\Http\Controllers;

use App\Http\Requests\Place\PlaceRequest;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class PlaceController extends Controller
{
    public function index(Request $request): Response
    {
        $places = Place::with([
            'categories',
            'images',
            'address.city',
            'reviews'
        ])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->whereHas('categories', function ($q) use ($request) {
                    $q->where('slug', $request->category);
                });
            })
            ->get()
            ->transform(function ($place) {
                return [
                    'id' => $place->id,
                    'name' => $place->name,
                    'slug' => $place->slug,
                    'description' => $place->description,
                    'rating' => round($place->reviews_avg_rating, 1),
                    'reviews_count' => $place->reviews_count,
                    'average_price' => 0,
                    'images' => $place->images,
                    'currentImageIndex' => 0,
                    'categories' => $place->categories,
                    'badges' => $this->getBadges($place),
                    'available_slots' => $this->getAvailableSlots(),
                    'address' => $place->address,
                ];
            });

        return Inertia::render('Places/Index', [
            'places' => $places,
            'location' => $request->get('location', 'Paris'),
            'filters' => $request->only(['category', 'price'])
        ]);
    }

    private function getBadges($place): array
    {
        $badges = [];

        if ($place->is_michelin) $badges[] = 'MICHELIN';
        if ($place->is_insider) $badges[] = 'INSIDER';

        return $badges;
    }

    private function getAvailableSlots(): array
    {
        // Mock data - implement real availability logic
        return ['12:00', '12:30', '13:00', '13:30', '14:00'];
    }

    public function show(Place $place)
    {
        $place->load([
            'address.city.country',
            'categories',
            'images',
            'reviews' => function($query) {
                $query->with([
                    'user' => fn($q) => $q->select('id', 'name', 'profile_photo_path')
                        ->withCount('reviews'),
                    'images'
                ])
                    ->latest()
                    ->take(5);
            }
        ]);

        return Inertia::render('Places/Show', [
            'place' => array_merge($place->toArray(), [
                'average_rating' => $place->reviews->avg('rating') ?? 0,
                'is_favorite' =>false,
            ])
        ]);
    }

    public function edit(Place $place)
    {
        $this->authorize('update', $place);

        $place->load(['images', 'categories', 'addresses.city.country']);

        return Inertia::render('Places/Edit', [
            'place' => $place,
            'categories' => Category::all(),
            'cities' => City::all(),
            'countries' => Country::all()
        ]);
    }

    public function update(PlaceRequest $request, Place $place)
    {
        $this->authorize('update', $place);

        $validated = $request->validated();
        $validated['slug'] = Str::slug($validated['name']);

        $place->update($validated);
        $place->categories()->sync($validated['categories']);

        if ($place->addresses->first()) {
            $place->addresses->first()->update($validated['address']);
        } else {
            $place->addresses()->create($validated['address']);
        }

        if (!empty($validated['deleted_images'])) {
            $place->images()->whereIn('id', $validated['deleted_images'])->delete();
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('places', 'public');
                $place->images()->create(['path' => $path]);
            }
        }

        return redirect()->route('places.index')
            ->with('success', 'Place updated successfully.');
    }

    public function create(): Response
    {
        $this->authorize('create', Place::class);

        return Inertia::render('Places/Create', [
            'categories' => Category::all(),
            'cities' => City::all(),
            'countries' => Country::all()
        ]);
    }

    public function store(PlaceRequest $request)
    {
        $this->authorize('create', Place::class);

        $validated = $request->validated();
        $validated['slug'] = Str::slug($validated['name']);
        $validated['user_id'] = auth()->id();

        $place = Place::create($validated);
        $place->categories()->attach($validated['categories']);
        $place->addresses()->create($validated['address']);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('places', 'public');
                $place->images()->create(['path' => $path]);
            }
        }

        return redirect()->route('places.index')
            ->with('success', 'Place created successfully.');
    }

    public function destroy(Place $place)
    {
        $this->authorize('delete', $place);

        $place->delete();

        return redirect()->route('places.index')
            ->with('success', 'Place deleted successfully.');
    }
}
