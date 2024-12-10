<?php

namespace App\Actions\Place;

use App\Models\Place;

class DeletePlace
{
    public function handle(Place $place): ?bool
    {
        return $place->delete();
    }
}
