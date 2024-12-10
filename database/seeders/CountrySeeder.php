<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $countries = [
            [
                "name" => "USA",
                "code" => "US",
                "cities" => [
                    ["name" => "New York"],
                    ["name" => "Los Angeles"],
                    ["name" => "Chicago"],
                    ["name" => "Houston"],
                    ["name" => "Phoenix"],
                    ["name" => "Philadelphia"],
                    ["name" => "San Antonio"],
                    ["name" => "San Diego"],
                    ["name" => "Dallas"],
                    ["name" => "San Jose"],
                ],
            ],
            [
                "name" => "Canada",
                "code" => "CA",
                "cities" => [
                    ["name" => "Toronto"],
                    ["name" => "Montreal"],
                    ["name" => "Vancouver"],
                    ["name" => "Calgary"],
                    ["name" => "Edmonton"],
                    ["name" => "Ottawa"],
                    ["name" => "Winnipeg"],
                    ["name" => "Quebec City"],
                    ["name" => "Hamilton"],
                    ["name" => "Victoria"],
                ],
            ],
            [
                "name" => "France",
                "code" => "FR",
                "cities" => [
                    ["name" => "Paris"],
                    ["name" => "Marseille"],
                    ["name" => "Lyon"],
                    ["name" => "Toulouse"],
                    ["name" => "Nice"],
                    ["name" => "Nantes"],
                    ["name" => "Strasbourg"],
                    ["name" => "Montpellier"],
                    ["name" => "Bordeaux"],
                    ["name" => "Lille"],
                ],
            ],
            [
                "name" => "Germany",
                "code" => "DE",
                "cities" => [
                    ["name" => "Berlin"],
                    ["name" => "Hamburg"],
                    ["name" => "Munich"],
                    ["name" => "Cologne"],
                    ["name" => "Frankfurt"],
                    ["name" => "Stuttgart"],
                    ["name" => "Düsseldorf"],
                    ["name" => "Dortmund"],
                    ["name" => "Essen"],
                    ["name" => "Bremen"],
                ],
            ],
            [
                "name" => "UK",
                "code" => "GB",
                "cities" => [
                    ["name" => "London"],
                    ["name" => "Birmingham"],
                    ["name" => "Manchester"],
                    ["name" => "Liverpool"],
                    ["name" => "Bristol"],
                    ["name" => "Glasgow"],
                    ["name" => "Edinburgh"],
                    ["name" => "Leeds"],
                    ["name" => "Cardiff"],
                    ["name" => "Sheffield"],
                ],
            ],
            // Add more countries with their respective cities here...
        ];

        foreach ( $countries as $country){
            $newCountry= Country::create([
                'name' => $country['name'],
                'code' => $country['code'],
            ]);
        /*    $necities=collect($country['cities'])->mapWithKeys(function ($item){
                return ['name' => $item];
            })->toArray();*/
            $newCountry->cities()->createMany($country['cities']);
        }

    }
}
