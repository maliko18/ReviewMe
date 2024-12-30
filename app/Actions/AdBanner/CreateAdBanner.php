<?php

namespace App\Actions\AdBanner;

use App\Models\Place;

class CreateAdBanner
{
    public function handle(Place $place,array $data)
    {
        return $place->adBanners()->create($data);
    }
}
