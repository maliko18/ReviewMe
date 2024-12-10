<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\City;
use App\Models\Country;
use App\Models\Image;
use App\Models\Place;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user=User::query()->first();
        Place::factory(10)
            ->has(
                Review::factory(20)
                    ->has(
                        Image::factory(3),
                        'images'
                    )
            )
            ->has(
                Image::factory(8),
                'images'
            )
            ->hasAttached($user)
            ->create()
           /* ->each(function ($place)  {
                $country=Country::query()->inRandomOrder()->first();
                $city=City::query()->where('country_id', $country->id)->inRandomOrder()->first();
                Address::factory()->create([
                    'addressable_id' => $place->id,
                    'addressable_type' => Place::class,
                    'city_id' => $country->id,
                    'country_id' =>$city->id,
                ]);
            })*/;
    }
}
