<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;

class ReviewPolicy
{
    public function update(User $user, Review $review)
    {
        return $user->hasRole('super-admin') ||
            $review->user_id === $user->id ||
            ($user->hasPermissionTo('edit reviews') && $review->place->isAdminBy($user));
    }

    public function delete(User $user, Review $review)
    {
        return $user->hasRole('super-admin') ||
            $review->user_id === $user->id ||
            ($user->hasPermissionTo('delete reviews') && $review->place->isAdminBy($user));
    }

    public function reply(User $user, Review $review)
    {
        return $user->hasPermissionTo('manage reviews') &&
            $review->place->isAdminBy($user);
    }
}
