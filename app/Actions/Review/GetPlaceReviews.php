<?php

namespace App\Actions\Review;

use App\Models\Place;
use Illuminate\Database\Eloquent\Collection;

class GetPlaceReviews
{
    public function handle(Place $place): Collection
    {
        return $place->reviews;
    }
}
