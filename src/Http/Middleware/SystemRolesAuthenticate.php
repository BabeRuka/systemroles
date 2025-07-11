<?php

namespace BabeRuka\SystemRoles\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;

class SystemRolesAuthenticate
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if (!auth()->guard($guards[0] ?? null)->check()) {
            // Option 1: Return JSON response for API-like behavior
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }
             
            return redirect()->route('login');
        }

        return $next($request);
    }
}