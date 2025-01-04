<?php

namespace App\Policies;

use App\Models\Place;
use App\Models\User;

class PlacePolicy
{
    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Place $place)
    {
        return true;
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('create places');
    }

    public function update(User $user, Place $place)
    {
        return $user->hasRole('super-admin') ||
            ($user->hasPermissionTo('edit places') && $place->isAdminBy($user));
    }

    public function delete(User $user, Place $place)
    {
        return $user->hasRole('super-admin') ||
            ($user->hasPermissionTo('delete places') && $place->isAdminBy($user));
    }
}
