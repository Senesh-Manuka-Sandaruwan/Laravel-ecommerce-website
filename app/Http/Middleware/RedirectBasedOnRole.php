<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class RedirectBasedOnRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $roleName = $user->role->name;

            if ($roleName === 'super_admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($roleName === 'clinic_admin') {
                return redirect()->route('dashboard');
            }
        }

        return redirect()->route('login');
    }
}
