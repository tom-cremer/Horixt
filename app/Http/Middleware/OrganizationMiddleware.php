<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class OrganizationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $organizationId = $request->route('id');

        Log::info($organizationId);
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $isMember = DB::table('organization_user')
            ->where('organization_id', $organizationId)
            ->where('user_id', auth()->id())
            ->where('is_active', true)
            ->exists();

        if (!$isMember) {
            Log::info("OrganizationMiddleware: User is not a member of the organization with ID {$organizationId}");
            return redirect()->route('personal.dashboard');
        }

        Log::info("OrganizationMiddleware: User is a member of the organization with ID {$organizationId}");
        // Adding organization id to session()
        session(['organization_id' => $organizationId]);

        return $next($request);
    }

}
