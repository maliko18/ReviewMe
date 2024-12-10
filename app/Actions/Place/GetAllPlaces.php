<?php

namespace App\Actions\Place;

use App\Models\Place;
use Illuminate\Database\Eloquent\Collection;

class GetAllPlaces
{
    public function handle(): Collection
    {
        return Place::all();
    }
}
