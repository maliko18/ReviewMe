<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->unique()->word(); 

        return [
            'name' => $name,
            'slug' => Str::slug($name), // Génère un slug basé sur le nom
            'description' => $this->faker->sentence(), // Une description factice
            'meta' => json_encode([
                'meta_title' => $name,
                'meta_description' => $this->faker->sentence(),
            ]), // Métadonnées factices
            'category_id' => null, // Pas de parent par défaut
        ];
    }
}
