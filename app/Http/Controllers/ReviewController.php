<?php

namespace App\Http\Controllers;

use App\Actions\Review\CreateReview;
use App\Http\Requests\Review\StoreReviewRequest;
use App\Http\Resources\Review\ReviewResource;
use App\Models\Place;
use Illuminate\Http\Request;

class ReviewController extends BaseController
{
    public function index()
    {
        //TODO
    }

    public function show()
    {
        //TODO
    }

    public function store(Place $place, StoreReviewRequest $request): ReviewResource
    {
        return ReviewResource::make((new CreateReview())->handle($place,$this->user , $request->validated()));
    }

    public function update()
    {
        //TODO
    }

    public function destroy()
    {
        //TODO
    }
}
