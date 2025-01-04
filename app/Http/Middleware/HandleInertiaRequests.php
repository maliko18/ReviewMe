<?php

namespace App\Http\Middleware;

use App\Models\Place;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user() ? [
                    'id' => $request->user()->id,
                    'name' => $request->user()->name,
                    'email' => $request->user()->email,
                    'profile_photo_url' => $request->user()->profile_photo_url,
                    'roles' => $request->user()->roles->pluck('name'),
                    'permissions' => $request->user()->getAllPermissions()->pluck('name'),
                ] : null,
            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
            ],
            'can' => [
                'create_places' => $request->user()?->can('create places'),
                'edit_places' => $request->user()?->can('edit places'),
                'delete_places' => $request->user()?->can('delete places'),
                'manage_places' => $request->user()?->can('manage place settings'),
                'create_reviews' => $request->user()?->can('create reviews'),
                'edit_reviews' => $request->user()?->can('edit reviews'),
                'delete_reviews' => $request->user()?->can('delete reviews'),
                'reply_to_reviews' => $request->user()?->can('manage reviews'),
                'manage_categories' => $request->user()?->can('manage categories'),
                'manage_events' => $request->user()?->can('manage events'),
                'manage_banners' => $request->user()?->can('manage ad_banners'),
                'access_admin' => $request->user()?->can('access admin panel'),
                'manage_users' => $request->user()?->can('manage users'),
                'manage_roles' => $request->user()?->can('manage roles'),
                'manage_settings' => $request->user()?->can('manage settings'),
            ],
            'app' => [
                'name' => config('app.name'),
                'env' => config('app.env'),
            ],
            'places' => fn () => $request->is('places*', 'reviews*', 'events*', 'banners*')
                ? Place::select('id', 'name')->get()
                : [],
        ]);
    }
}
