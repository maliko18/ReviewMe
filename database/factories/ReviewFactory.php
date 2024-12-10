<?php

namespace Database\Factories;

use App\Models\Place;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'body' => $this->faker->text(),
            'rating' => $this->faker->numberBetween(1, 5),
            'meta' => json_encode(['approved' => $this->faker->boolean()]),
            'user_id' => User::factory(),
            'place_id' => Place::factory(),
        ];
    }
}
