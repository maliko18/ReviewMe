<?php

namespace App\Actions\PlaceEvent;

use App\Models\Place;
use App\Models\PlaceEvent;

class CreatePlaceEvent
{
    public function handle(Place $place, array $data): PlaceEvent
    {
        return $place->placeEvents()->create($data);
    }
}
