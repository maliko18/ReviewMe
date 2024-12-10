<?php

namespace App\Http\Controllers;

use App\Actions\Place\UpdateOrCreatePlace;
use App\Actions\Place\DeletePlace;
use App\Actions\Place\GetAllPlaces;
use App\Actions\Place\GetPlace;
use App\Http\Requests\Place\StorePlaceRequest;
use App\Http\Requests\Place\UpdatePlaceRequest;
use App\Http\Resources\Place\PlaceResource;
use App\Models\Place;
use App\Services\PlaceService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PlaceController extends BaseController
{
    public function __construct(private readonly PlaceService $placeService)
    {
        parent::__construct();
    }

    public function index(): AnonymousResourceCollection
    {
        return PlaceResource::collection($this->placeService->lisPlaces());
    }
    public function store(StorePlaceRequest $request): PlaceResource
    {
        return PlaceResource::make($this->placeService->create($request->validated()));
    }
    public function show(Place $place): PlaceResource
    {
        return PlaceResource::make($this->placeService->getPlace($place));
    }
    public function edit($id)
    {
        //TODO
    }
    public function update(Place $place,UpdatePlaceRequest $request): PlaceResource
    {
        return PlaceResource::make($this->placeService->update($place,$request->validated()));
    }
    public function destroy(Place $place): JsonResponse
    {
       return response()->json(['status'=>$this->placeService->delete($place)]);
    }
}
