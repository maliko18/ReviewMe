<?php

namespace App\Http\Controllers;

use App\Actions\City\GetCitiesByCountry;
use Illuminate\Http\JsonResponse;

class CityController extends Controller
{
    public function index($countryId): JsonResponse
    {
        return response()->json((new GetCitiesByCountry())->handle($countryId));
    }
}
