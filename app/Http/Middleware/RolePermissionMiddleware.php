<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RolePermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission = null)
    {
        $user = Auth::user();

        // Check if the user is authenticated
        if (!$user) {
            return redirect()->route('login')->with('error', 'Unauthorized access.');
        }

        // Check if the user has a role and permission
        if ($permission && !$user->role->permissions->pluck('name')->contains($permission)) {
            return redirect()->route('unauthorized')->with('error', 'Access denied.');
        }

        return $next($request);
    }
}
