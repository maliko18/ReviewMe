<?php

namespace App\Policies;

use App\Models\PlaceEvent;
use App\Models\User;
use App\Models\Place;

class PlaceEventPolicy
{
    public function create(User $user, Place $place): bool
    {
        return $user->hasRole('super-admin') ||
            ($user->hasPermissionTo('create events') && $place->isAdminBy($user));
    }

    public function update(User $user, PlaceEvent $event): bool
    {
        return $user->hasRole('super-admin') ||
            ($user->hasPermissionTo('edit events') && $event->place->isAdminBy($user));
    }

    public function delete(User $user, PlaceEvent $event): bool
    {
        return $user->hasRole('super-admin') ||
            ($user->hasPermissionTo('delete events') && $event->place->isAdminBy($user));
    }
}

