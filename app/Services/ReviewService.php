<?php

namespace App\Services;

use App\Actions\Image\AttachImagesToModel;
use App\Actions\Image\RemoveImagesWithIds;
use App\Actions\Review\CreateReview;
use App\Actions\Review\GetPlaceReviews;
use App\Actions\Review\UpdateReview;
use App\Models\Place;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ReviewService
{
    public function getReview($review)
    {
        return $review;
    }

    public function create(User $user,Place $place,$data):Review
    {
        return DB::transaction(function () use ($user,$place,$data) {
            $review = (new CreateReview())->handle($place, $user, $data);
            if (isset($data['images'])) {
                (new AttachImagesToModel())->handle($review, $data['images']);
            }
            return $review;
        });
    }

    public function update(Review $review,array $data):Review
    {
        return DB::transaction(function () use ($review,$data) {
            $review = (new UpdateReview())->handle($review,$data);
            if (isset($data['remove_image_ids'])) {
                (new RemoveImagesWithIds())->handle($data['remove_image_ids']);
            }
            if (isset($data['images'])) {
                (new AttachImagesToModel())->handle($review, $data['images']);
            }
            return $review;
        });
    }

    public function delete($review): bool
    {
        return $review->delete();
    }
    public function getPlaceReview(Place $place): Collection
    {
        return (new GetPlaceReviews())->handle($place);
    }

}
