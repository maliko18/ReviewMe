<?php
// app/Http/Controllers/PlaceEventController.php

namespace App\Http\Controllers;

use App\Models\PlaceEvent;
use App\Models\Place;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class PlaceEventController extends Controller
{
    public function index()
    {
        $events = QueryBuilder::for(PlaceEvent::class)
            ->allowedFilters([
                AllowedFilter::exact('place_id'),
                AllowedFilter::exact('status'),
                AllowedFilter::callback('search', fn($query, $value) =>
                $query->where('name', 'like', "%{$value}%")
                    ->orWhere('description', 'like', "%{$value}%")
                ),
                AllowedFilter::callback('date', function($query, $value) {
                    return match($value) {
                        'upcoming' => $query->where('start_date', '>', now()),
                        'past' => $query->where('end_date', '<', now()),
                        'current' => $query->where('start_date', '<=', now())
                            ->where('end_date', '>=', now()),
                        default => $query
                    };
                })
            ])
            ->with('place')
            ->latest('start_date')
            ->paginate()
            ->withQueryString();

        return Inertia::render('Events/Index', [
            'events' => $events,
            'places' => auth()->user()->can('create events') ?
                Place::select('id', 'name')->get() : []
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'status' => 'required|boolean',
            'place_id' => 'required|exists:places,id',
            'meta' => 'nullable|json'
        ]);

        $place = Place::findOrFail($validated['place_id']);
        $this->authorize('create', [PlaceEvent::class, $place]);

        PlaceEvent::create($validated);

        return redirect()->back()
            ->with('success', 'Event created successfully');
    }

    public function update(Request $request, PlaceEvent $event)
    {
        $this->authorize('update', $event);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'status' => 'required|boolean',
            'meta' => 'nullable|json'
        ]);

        $event->update($validated);

        return redirect()->back()
            ->with('success', 'Event updated successfully');
    }

    public function destroy(PlaceEvent $event)
    {
        $this->authorize('delete', $event);

        $event->delete();

        return redirect()->back()
            ->with('success', 'Event deleted successfully');
    }
}
