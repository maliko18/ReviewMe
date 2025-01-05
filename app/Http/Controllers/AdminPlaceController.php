<?php

namespace App\Http\Controllers;

use App\Http\Requests\Place\PlaceRequest;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Place;
use App\Services\PlaceService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class AdminPlaceController extends Controller
{
    protected PlaceService $placeService;

    public function __construct(PlaceService $placeService)
    {
        $this->placeService = $placeService;
    }

    public function index(): Response
    {
        $places = $this->placeService->getPlacesWithFilters();

        return Inertia::render('Admin/Places/Index', [
            'places' => $places,
            'categories' => Category::all(),
            'cities' => City::all(),
            'countries' => Country::all(),
        ]);
    }

    public function show(Place $place): Response
    {
        $place = $this->placeService->getPlaceDetails($place);

        return Inertia::render('Admin/Places/Show', [
            'place' => $place,
        ]);
    }

    public function edit(Place $place): Response
    {
        $this->authorize('update', $place);

        $place = $this->placeService->loadPlaceForEdit($place);

        return Inertia::render('Admin/Places/Edit', [
            'place' => $place,
            'categories' => Category::all(),
            'cities' => City::all(),
            'countries' => Country::all(),
        ]);
    }

    public function update(PlaceRequest $request, Place $place)
    {
        $this->authorize('update', $place);

        $this->placeService->updatePlace($place, $request);

        return redirect()->route('places.index')
            ->with('success', 'Place updated successfully.');
    }

    public function create(): Response
    {
        $this->authorize('create', Place::class);

        return Inertia::render('Admin/Places/Create', [
            'categories' => Category::all(),
            'cities' => City::all(),
            'countries' => Country::all(),
        ]);
    }

    public function store(PlaceRequest $request)
    {
        $this->authorize('create', Place::class);

        $this->placeService->storePlace($request);

        return redirect()->route('admin.places.index')
            ->with('success', 'Place created successfully.');
    }

    public function destroy(Place $place)
    {
        $this->authorize('delete', $place);

        $this->placeService->deletePlace($place);

        return redirect()->route('admin.places.index')
            ->with('success', 'Place deleted successfully.');
    }
}
