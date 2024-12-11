<?php

namespace App\Actions\Place;

use App\Models\Place;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;

class GetAllPlaces
{
    public function handle(): Collection
    {
      return QueryBuilder::for(Place::class)
        ->allowedIncludes(
            [
                'images',
                'addresses',
                'categories',
                'tags',
                'user',
                'reviews'])
        ->get();
    }
}
