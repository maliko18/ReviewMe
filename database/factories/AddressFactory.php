<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'address' => $this->faker->address(),
            'state' => $this->faker->state(),
            'zip' => $this->faker->postcode(),
            'coordinates' => json_encode([
                'lat' => $this->faker->latitude(),
                'lng' => $this->faker->longitude(),
            ]),
            'meta' => json_encode(['landmark' => $this->faker->word()]),
            'addressable_id' => null,
            'addressable_type' => null,
            'city_id' => null,
            'country_id' => null,
        ];
    }
}
