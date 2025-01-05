<?php
// app/Http/Controllers/ReviewController.php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ReviewController extends Controller
{
    public function index(): Response
    {
        $reviews = QueryBuilder::for(Review::class)
            ->allowedFilters([
                AllowedFilter::exact('place_id'),
                AllowedFilter::exact('user_id'),
                AllowedFilter::exact('rating'),
                AllowedFilter::callback('search', fn($query, $value) => $query->where('body', 'like', "%{$value}%")
                )
            ])
            ->with(['user', 'place', 'images'])
            ->withCount('replay')
            ->latest()
            ->paginate()
            ->withQueryString();

        return Inertia::render('Reviews/Index', [
            'reviews' => $reviews,
            'places' => Place::select('id', 'name')->get()
        ]);
    }

    public function update(Request $request, Review $review)
    {
        $this->authorize('update', $review);

        $validated = $request->validate([
            'body' => 'required|string',
            'rating' => 'required|integer|between:1,5',
            'meta' => 'nullable|json',
            'images.*' => 'image|max:2048',
            'deleted_images' => 'nullable|array',
            'deleted_images.*' => 'exists:images,id'
        ]);

        $review->update($validated);

        if (!empty($validated['deleted_images'])) {
            $review->images()->whereIn('id', $validated['deleted_images'])->delete();
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('reviews', 'public');
                $review->images()->create(['path' => $path]);
            }
        }

        return redirect()->back()
            ->with('success', 'Review updated successfully');
    }

    public function store(Place $place, Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'body' => 'required|string',
            'rating' => 'required|integer|between:1,5',
            'meta' => 'nullable|json',
            'images.*' => 'image|max:2048'
        ]);
        $review=$place->reviews()->create([
            ...$validated,
            'user_id' => auth()->id()
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('reviews', 'public');
                $review->images()->create(['path' => $path]);
            }
        }

        return redirect()->route('places.show', $place->id)
            ->with('success', 'Place deleted successfully.');
    }

    public function destroy(Review $review)
    {
        $this->authorize('delete', $review);

        $review->delete();

        return redirect()->back()
            ->with('success', 'Review deleted successfully');
    }

    public function reply(Request $request, Review $review)
    {
        $this->authorize('reply', $review);

        $validated = $request->validate([
            'body' => 'required|string',
            'meta' => 'nullable|json',
            'images.*' => 'image|max:2048'
        ]);

        $reply = Review::create([
            ...$validated,
            'rating' => $review->rating,
            'place_id' => $review->place_id,
            'parent_id' => $review->id,
            'user_id' => auth()->id()
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('reviews', 'public');
                $reply->images()->create(['path' => $path]);
            }
        }

        return redirect()->back()
            ->with('success', 'Reply added successfully');
    }
}
