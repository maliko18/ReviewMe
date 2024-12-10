<?php

namespace App\Http\Controllers;

use App\Actions\Place\CreatePlace;
use App\Actions\Place\DeletePlace;
use App\Actions\Place\GetAllPlaces;
use App\Actions\Place\GetPlace;
use App\Actions\Place\UpdatePlace;
use App\Http\Requests\Place\StorePlaceRequest;
use App\Http\Requests\Place\UpdatePlaceRequest;
use App\Http\Resources\Place\PlaceResource;
use App\Models\Place;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PlaceController extends BaseController
{
    public function index(): AnonymousResourceCollection
    {
        return PlaceResource::collection((new GetAllPlaces())->handle());
    }
    public function store(StorePlaceRequest $request): PlaceResource
    {
        return PlaceResource::make((new CreatePlace())->handle($this->user,$request->validated()));
    }
    public function show(Place $place): PlaceResource
    {
        return PlaceResource::make((new GetPlace())->handle($place));
    }
    public function edit($id)
    {
        //TODO
    }
    public function update(Place $place,UpdatePlaceRequest $request): PlaceResource
    {
        return PlaceResource::make((new UpdatePlace())->handle($place,$request->validated()));
    }
    public function destroy(Place $place): JsonResponse
    {
       return response()->json(['status'=>(new DeletePlace())->handle($place)]);
    }
}
