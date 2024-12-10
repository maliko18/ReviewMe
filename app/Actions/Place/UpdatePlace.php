<?php

namespace App\Actions\Place;

use App\Models\Place;

class UpdatePlace
{
    public function handle(Place $place, array $data): Place
    {
        $place->update($data);

        return $place;
    }
}
