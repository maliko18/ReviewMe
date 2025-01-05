<?php

namespace App\Actions\PlaceEvent;

use App\Models\Place;
use App\Models\PlaceEvent;
use Spatie\QueryBuilder\QueryBuilder;

class GetPlaceEvent
{
    public function handle(PlaceEvent $placeEvent): PlaceEvent
    {
        return QueryBuilder::for(PlaceEvent::class)
            ->allowedIncludes([
                'place',
            ])
            ->where('id', $placeEvent->id)
            ->firstOrFail();
    }
}
