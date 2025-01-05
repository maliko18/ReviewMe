<?php

namespace Database\Factories;

use App\Models\Place;
use App\Models\PlaceEvent;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PlaceEvent>
 */
class PlaceEventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

            'name' => $this->faker->text(50),
            'description' => $this->faker->text(200),
            'start_date' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'end_date' => $this->faker->dateTimeBetween('+1 month', '+2 month'),
            'place_id' => Place::factory(),
        ];
    }
}
