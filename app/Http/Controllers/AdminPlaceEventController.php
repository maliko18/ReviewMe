<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlaceEvent\StorePlaceEventRequest;
use App\Http\Requests\PlaceEvent\UpdatePlaceEventRequest;
use App\Models\Place;
use App\Models\PlaceEvent;
use App\Services\PlaceEventService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class AdminPlaceEventController extends Controller
{
    protected PlaceEventService $placeEventService;

    public function __construct(PlaceEventService $placeEventService)
    {
        $this->placeEventService = $placeEventService;
    }

    public function index(): Response
    {
        $events = $this->placeEventService->getFilteredEvents();

        return Inertia::render('Admin/Events/Index', [
            'events' => $events,
            'places' => Place::select('id', 'name')->get(),
            'filters' => request()->only(['search', 'place_id', 'status', 'date_range']),
        ]);
    }

    public function store(StorePlaceEventRequest $request): RedirectResponse
    {
        $this->placeEventService->storeEvent($request);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event created successfully.');
    }

    public function update(UpdatePlaceEventRequest $request, PlaceEvent $event): RedirectResponse
    {
        $this->placeEventService->updateEvent($event, $request);
        return redirect()->route('admin.events.index')
            ->with('success', 'Event updated successfully.');
    }

    public function destroy(PlaceEvent $event): RedirectResponse
    {
        $this->placeEventService->deleteEvent($event);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event deleted successfully.');
    }
}
