<?php

namespace App\Policies;

use App\Models\AdBanner;
use App\Models\User;
use App\Models\Place;

class AdBannerPolicy
{
    public function create(User $user, Place $place): bool
    {
        return $user->hasRole('super-admin') ||
            ($user->hasPermissionTo('create ad_banners') && $place->isAdminBy($user));
    }

    public function update(User $user, AdBanner $banner): bool
    {
        return $user->hasRole('super-admin') ||
            ($user->hasPermissionTo('edit ad_banners') && $banner->place->isAdminBy($user));
    }

    public function delete(User $user, AdBanner $banner): bool
    {
        return $user->hasRole('super-admin') ||
            ($user->hasPermissionTo('delete ad_banners') && $banner->place->isAdminBy($user));
    }
}
