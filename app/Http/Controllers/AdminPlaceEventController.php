<?php
// app/Http/Controllers/PlaceEventController.php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\PlaceEvent;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class AdminPlaceEventController extends Controller
{
    public function index(): Response
    {
        $events = QueryBuilder::for(PlaceEvent::class)
            ->allowedFilters([
                AllowedFilter::exact('place_id'),
                AllowedFilter::exact('status'),
                AllowedFilter::callback('search', function ($query, $value) {
                    $query->where(function ($query) use ($value) {
                        $query->where('name', 'like', "%{$value}%")
                            ->orWhere('description', 'like', "%{$value}%")
                            ->orWhereHas('place', function ($query) use ($value) {
                                $query->where('name', 'like', "%{$value}%");
                            });
                    });
                }),
                AllowedFilter::scope('date_range'),
            ])
            ->allowedSorts(['start_date', 'end_date', 'created_at'])
            ->defaultSort('-start_date')
            ->with(['place'])
            ->paginate()
            ->withQueryString();
        return Inertia::render('Admin/Events/Index', [
            'events' => $events,
            'places' => Place::select('id', 'name')->get(),
            'filters' => request()->only(['search', 'place_id', 'status', 'date_range'])
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
       /*     'status' => 'required|boolean',*/
            'place_id' => 'required|exists:places,id',
        ]);
        PlaceEvent::query()->create($validated);
        return redirect()->route('admin.events.index')
            ->with('success', 'Event created successfully.');
    }

    public function update(Request $request, PlaceEvent $event)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|boolean',
            'place_id' => 'required|exists:places,id',
        ]);

        $event->update($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event updated successfully.');
    }

    public function destroy(PlaceEvent $event)
    {
        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Event deleted successfully.');
    }
}
