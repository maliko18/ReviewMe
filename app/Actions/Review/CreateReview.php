<?php

namespace App\Actions\Review;

use App\Models\Place;
use App\Models\Review;
use App\Models\User;

class CreateReview
{
    public function handle(Place $place,User $user, array $data):Review
    {

        $data=array_merge($data, ['user_id' => $user->id]);
        return $place->reviews()->create($data);
    }
}
