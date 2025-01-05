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

        $this->call(CountrySeeder::class);
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(CategorySeeder::class);

        // User::factory(10)->withPersonalTeam()->create();

        $user =User::factory()->withPersonalTeam()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'super@admin.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $superAdmin->assignRole('super-admin');

        // Create Place Admin
        $placeAdmin = User::create([
            'name' => 'Place Admin',
            'email' => 'place@admin.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $placeAdmin->assignRole('place-admin');

        // Create Normal User
        $user = User::create([
            'name' => 'Normal User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $user->assignRole('user');

        // Create Demo Place Admin
        $demoPlaceAdmin = User::create([
            'name' => 'Demo Place Admin',
            'email' => 'demo@place.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $demoPlaceAdmin->assignRole('place-admin');

        // Factory Users with Random Roles
        User::factory(10)->create()->each(function ($user) {
            $user->assignRole(['user', 'place-admin'][rand(0, 1)]);
        });
        $this->call(PlaceSeeder::class);

    }

}
