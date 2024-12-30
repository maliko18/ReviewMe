<?php

namespace App\Http\Controllers;

use App\Actions\AdBanner\CreateAdBanner;
use App\Http\Requests\AdBanner\StoreAdBannerRequest;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AdBannerController extends Controller
{
    public function index()
    {
        //TODO
    }

    public function store(Place $place, StoreAdBannerRequest $request): JsonResponse
    {
        return response()->json([
            'ad_banner' => (new CreateAdBanner())->handle($place, $request->validated())
        ]);
    }

    public function show($id)
    {
        //TODO
    }

    public function update(Request $request, $id)
    {
        //TODO
    }

    public function destroy($id)
    {
        //TODO
    }
}
