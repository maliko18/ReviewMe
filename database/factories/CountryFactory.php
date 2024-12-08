<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Country>
 */
class CountryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->country(),
            'code' => $this->faker->unique()->countryCode(),
            'meta' => json_encode([
                'continent' => $this->faker->randomElement([
                    'Africa', 'Asia', 'Europe', 'North America', 'South America', 'Oceania', 'Antarctica'
                ]),
                'population' => $this->faker->numberBetween(1_000_000, 100_000_000),
            ]),

        ];
    }
}
