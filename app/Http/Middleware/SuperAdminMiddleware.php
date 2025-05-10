<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // app/Http/Middleware/EnsureSuperAdmin.php

    public function handle($request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->administrator) {
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }

}
