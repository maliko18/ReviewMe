<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\City;
use App\Models\Country;
use App\Models\Image;
use App\Models\Place;
use App\Models\Review;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->withPersonalTeam()->create();

        $user =User::factory()->withPersonalTeam()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);
        $this->call(CountrySeeder::class);
        $this->call(PlaceSeeder::class);

    }

}
