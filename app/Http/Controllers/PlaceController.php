<?php

namespace App\Http\Controllers;

use App\Http\Requests\Place\PlaceRequest;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Place;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class PlaceController extends Controller
{
    public function index(): Response
    {
        $places = Place::with(['images', 'categories', 'addresses.city.country'])
            ->withCount(['reviews', 'placeEvents'])
            ->latest()
            ->paginate();

        return Inertia::render('Places/Index', [
            'places' => $places
        ]);
    }

    public function show(Place $place)
    {
        $place->load(['images', 'categories', 'addresses.city.country', 'reviews.user']);

        return Inertia::render('Places/Show', [
            'place' => $place
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
