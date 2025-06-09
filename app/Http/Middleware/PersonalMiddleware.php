<?php

namespace App\Http\Middleware;

use Closure;

class PersonalMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle($request, Closure $next)
    {
        // Check if the user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        // Clear any active org session
        session()->forget(['organization_id', 'team_id']);
        return $next($request);
    }

}
