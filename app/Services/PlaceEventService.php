<?php

namespace App\Services;

use App\Actions\PlaceEvent\CreatePlaceEvent;
use App\Actions\PlaceEvent\GetAllPlaceEvents;
use App\Actions\PlaceEvent\GetPlaceEvent;
use App\Actions\PlaceEvent\UpdatePlaceEvent;
use App\Models\Place;
use App\Models\PlaceEvent;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class PlaceEventService
{
    public function create(Place $place, array $data): PlaceEvent
    {
        return DB::transaction(function () use ($place, $data) {
            return (new CreatePlaceEvent())->handle($place,  $data);
        });
    }
    public function update(PlaceEvent $placeEvent, array $data): PlaceEvent
    {
        return DB::transaction(function () use ($placeEvent, $data) {
            $updatedEvent = (new UpdatePlaceEvent())->handle($placeEvent, $data);
            return $updatedEvent;
        });
    }

    public function delete(PlaceEvent $placeEvent): bool
    {
        return $placeEvent->delete();
    }

    public function getAllPlaceEvents(): Collection
    {
        return (new GetAllPlaceEvents())->handle();
    }

    public function getPlaceEvent(PlaceEvent $placeEvent): PlaceEvent
    {
        return (new GetPlaceEvent())->handle( $placeEvent);
    }
}
