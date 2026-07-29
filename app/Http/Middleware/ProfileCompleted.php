<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProfileCompleted
{
    public function handle(Request $request, Closure $next)
    {
        if (! auth()->user()->profile_completed) {

            return redirect()->route('setup.profile');
        }

        return $next($request);
    }
}
