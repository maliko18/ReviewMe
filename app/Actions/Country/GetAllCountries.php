<?php

namespace App\Actions\Country;

use App\Models\Country;
use Illuminate\Database\Eloquent\Collection;

class GetAllCountries
{
    public function handle(): Collection
    {
        return Country::all();
    }
}
