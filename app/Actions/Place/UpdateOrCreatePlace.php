<?php

namespace App\Actions\Place;

use App\Models\Place;
use App\Models\User;
use Illuminate\Support\Str;

class UpdateOrCreatePlace
{
    public function handle( array $data):Place
    {
        $data['slug']=Str::of($data['name'])->snake()->toString();
        return Place::query()->updateOrCreate(
            ['id' => $data['id'] ?? null],
            $data
        );
    }
}
