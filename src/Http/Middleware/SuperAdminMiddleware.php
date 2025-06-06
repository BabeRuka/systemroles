<?php

namespace BabeRuka\SystemRoles\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;  
use BabeRuka\SystemRoles\UserRole;
use Session;

class SuperAdminMiddleware
{
     /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    { 
        if (!Auth::check()) { 
            return redirect('/login')->with('error', 'Please log in to access this page.'); 
        }
 
        $user = Auth::user();
 

        $user = Auth::user();

        $roleId = $user->roles->first()->role_id ?? null;

        $isSuperAdmin = false;

        if ($roleId == 1) { 
            $isSuperAdmin = true;
        }

        if (!$isSuperAdmin) { 
            session()->flash('error', 'Access Denied. You do not have sufficient privileges.');
            return redirect('/dashboard');
        }
 
        return $next($request);
    }
}
