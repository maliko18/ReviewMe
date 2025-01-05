<?php

namespace App\Actions\PlaceEvent;

use App\Models\PlaceEvent;
use Illuminate\Database\Eloquent\Collection;

class GetAllPlaceEvents
{
    public function handle(): Collection
    {
        return PlaceEvent::all();
    }
}
