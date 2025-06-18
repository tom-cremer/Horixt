<?php

namespace App\Http\Middleware;

use App\Models\Badges;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckNfcToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->route('token');
        $badge = Badges::where('token', $token)->first();

        if (!$badge) {
            return redirect()->route('home');
        }
        return $next($request);
    }

}
