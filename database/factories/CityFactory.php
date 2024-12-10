<?php

namespace Database\Factories;
use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\City>
 */
class CityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = City::class;

    public function definition(): array
    {
        $cities = [
            'Paris', 'La Rochelle', 'Marseille', 'Lyon', 'Toulouse', 'Nice', 'Nantes', 'Montpellier', 'Strasbourg', 'Bordeaux', 'Lille'
        ];

        return [
            'name' => $this->faker->randomElement($cities),
            'country_id' => Country::where('name', 'France')->value('id'),
        ];
    }
}
