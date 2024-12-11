<?php

namespace App\Http\Controllers;

use App\Actions\Review\CreateReview;
use App\Http\Requests\Review\StoreReviewRequest;
use App\Models\Place;
use Illuminate\Http\RedirectResponse;

class ReviewController extends BaseController
{
    public function index(Place $place, StoreReviewRequest $request)
    {

    }

    public function show()
    {
        //TODO
    }

    public function store(Place $place, StoreReviewRequest $request): RedirectResponse
    {
        $review = (new CreateReview())->handle($place, $this->user, $request->validated());
        return redirect()->route('places.show', $place->slug);
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
