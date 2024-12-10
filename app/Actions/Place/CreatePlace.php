<?php

namespace App\Actions\Place;

use App\Models\Place;
use App\Models\User;
use Illuminate\Support\Str;

class CreatePlace
{
    public function handle( User $user, array $data):Place
    {
        $data['slug']=Str::of($data['name'])->snake()->toString();
        return $user->places()->create($data);
    }
}
