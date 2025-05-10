<?php

namespace App\Http\Middleware;

use App\Models\OrganizationInvites;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckInviteTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->route('token');
        if (!$token) {
            return auth()->check()
                ? redirect()->route('personal.dashboard')
                : redirect()->route('login');
        }

        $invite = OrganizationInvites::where('token', $token)->first();

        if (!$invite) {
            return auth()->check()
                ? redirect()->route('personal.dashboard')
                : redirect()->route('login');
        }

        return $next($request);
    }
}
