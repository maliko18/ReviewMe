<?php

namespace App\Actions\Review;

use App\Models\Review;

class UpdateReview
{
    public function handle(Review $review,array $data): Review
    {
        $review->update($data);
        return  $review->refresh();
    }
}
