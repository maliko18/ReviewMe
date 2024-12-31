<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlaceEvent\StorePlaceEventRequest;
use App\Http\Requests\PlaceEvent\UpdatePlaceEventRequest;
use App\Http\Resources\PlaceEvent\PlaceEventResource;
use App\Models\Place;
use App\Models\PlaceEvent;
use App\Services\PlaceEventService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class PlaceEventController extends Controller
{
    public function __construct(private readonly PlaceEventService $placeEventService)
    {
    }

    public function store(Place $place,StorePlaceEventRequest $request): PlaceEventResource
    {
        $placeEvent = $this->placeEventService->create($place, $request->validated());
        return PlaceEventResource::make($placeEvent);
    }

    public function update(PlaceEvent $placeEvent, UpdatePlaceEventRequest $request): PlaceEventResource
    {
        return PlaceEventResource::make($this->placeEventService->update($placeEvent, $request->validated()));
    }

    public function destroy(PlaceEvent $placeEvent): JsonResponse
    {
        if (!$placeEvent) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        $status = $this->placeEventService->delete($placeEvent);
        return response()->json(['status' => $status]);
    }

    public function index(): JsonResponse
    {
        return response()->json([
            'placeEvents' => $this->placeEventService->getAllPlaceEvents()
        ]);
    }

    public function show(PlaceEvent  $placeEvent): JsonResponse
    {
        return response()->json([
            'placeEvents' => $this->placeEventService->getPlaceEvent($placeEvent)
        ]);

    }


}
