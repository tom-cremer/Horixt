<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class PersonalMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Check if the user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        Log::info("PersonalMiddleware: User is authenticated");
        // Clear any active org session
        session()->forget('organization_id');
        return $next($request);
    }

}
