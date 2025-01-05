<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Restaurant', 'slug' => 'restaurant'],
            ['name' => 'Café', 'slug' => 'cafe'],
            ['name' => 'Bar', 'slug' => 'bar'],
            ['name' => 'Bistro', 'slug' => 'bistro'],
            ['name' => 'Brasserie', 'slug' => 'brasserie'],
            ['name' => 'Fast Food', 'slug' => 'fast-food'],
            ['name' => 'Food Court', 'slug' => 'food-court'],
            ['name' => 'Food Truck', 'slug' => 'food-truck'],
            ['name' => 'Fine Dining', 'slug' => 'fine-dining'],
            ['name' => 'Casual Dining', 'slug' => 'casual-dining'],
            ['name' => 'Pub', 'slug' => 'pub'],
            ['name' => 'Nightclub', 'slug' => 'nightclub'],
            ['name' => 'Lounge', 'slug' => 'lounge'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
