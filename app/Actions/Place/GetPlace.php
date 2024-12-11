<?php

namespace App\Actions\Place;

use App\Models\Place;
use Spatie\QueryBuilder\QueryBuilder;

class GetPlace
{
    public function handle(Place $place): Place
    {
        return QueryBuilder::for(Place::class)
            ->allowedIncludes(
                [
                    'images',
                    'addresses',
                    'categories',
                    'tags',
                    'user',
                    'reviews'
                ])
            ->withCount('reviews')
            ->with('images', 'addresses', 'user', 'reviews', 'reviews.user')
            ->where('id', $place->id)
            ->first();
    }
}
