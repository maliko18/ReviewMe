<?php

namespace App\Actions\Place;

use App\Models\Place;

class GetPlace
{
    public function handle(Place $place): Place
    {
        return $place;
    }
}
