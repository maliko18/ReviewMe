<?php

namespace App\Actions\City;

use App\Models\City;
use Illuminate\Database\Eloquent\Collection;


class GetCitiesByCountry
{
    public function handle($countryId): Collection
    {
        return City::where('country_id', $countryId)->get();
    }
}
