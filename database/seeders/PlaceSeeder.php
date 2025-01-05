<?php

namespace Database\Seeders;

use App\Models\AdBanner;
use App\Models\Address;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Place;
use App\Models\PlaceEvent;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::factory(5)->create();
        $adminUser = User::query()->first();
        $categories = Category::all();

        Place::factory(20)
            ->hasAttached($adminUser)
            ->create()
            ->each(function ($place) use ($categories, $users) {

                    $country=Country::query()->inRandomOrder()->first();
                    $city=City::query()->where('country_id', $country->id)->inRandomOrder()->first();
                    if ($country and $city){
                        Address::factory()->create([
                            'addressable_id' => $place->id,
                            'addressable_type' => Place::class,
                            'city_id' => $city->id,
                            'country_id' =>$country->id,
                        ]);
                    }
                // Random images from public/images folders
                collect(File::files(public_path('images')))
                    ->random(6)
                    ->each(function ($file) use ($place) {

                        $path = Storage::disk('public')->putFileAs(
                            'places',
                            $file,
                            uniqid() . '_' . $file->getFilename()
                        );
                        $place->images()
                            ->create(['path' => $path]);
                    });

                // Reviews
                Review::factory(10)
                    ->for($users->random())
                    ->for($place)
                    ->create()
                    ->each(function ($review) {
                        collect(File::files(public_path('images')))
                            ->random(3)
                            ->each(function ($file) use ($review) {
                                $path = Storage::disk('public')->putFileAs(
                                    'reviews',
                                    $file,
                                    uniqid() . '_' . $file->getFilename()
                                );
                                $review->images()
                                    ->create(['path' => $path]);
                            });
                    });

                // Events
                PlaceEvent::factory(3)
                    ->for($place)
                    ->create()
                    ->each(function ($event) {
                        collect(File::files(public_path('images')))
                            ->random(4)
                            ->each(function ($file) use ($event) {
                                $path = Storage::disk('public')->putFileAs(
                                    'events',
                                    $file,
                                    uniqid() . '_' . $file->getFilename()
                                );
                                $event->images()
                                    ->create(['path' => $path]);
                            });
                    });

                // Ad Banners
                AdBanner::factory(2)
                    ->for($place)
                    ->create()
                    ->each(function ($banner) {
                        collect(File::files(public_path('images')))
                            ->random(3)
                            ->each(function ($file) use ($banner) {
                                $path = Storage::disk('public')->putFileAs(
                                    'banners',
                                    $file,
                                    uniqid() . '_' . $file->getFilename()
                                );
                                $banner->images()
                                    ->create(['path' => $path]);
                            });
                    });

                $place->categories()->attach($categories->random(3));
            });
    }

}
