<?php

namespace App\Actions\PlaceEvent;

use App\Models\PlaceEvent;

class UpdatePlaceEvent
{
    public function handle(PlaceEvent $placeEvent, array $data): PlaceEvent
    {
        $placeEvent->update($data);
        return $placeEvent;
    }
}
