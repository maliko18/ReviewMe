<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPlaceAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $place = $request->route('place');

        if (!$place) {
            return redirect()->route('places.index')
                ->with('error', 'Place not found.');
        }

        if (auth()->user()->hasRole('super-admin')) {
            return $next($request);
        }

        if (!$place->isAdminBy(auth()->user())) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
