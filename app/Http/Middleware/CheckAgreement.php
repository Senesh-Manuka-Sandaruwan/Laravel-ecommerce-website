<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class CheckAgreement
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();
        $status = DB::table('agreement')->where('Mmddleware_id',1111)->first();
        // Ensure the user is a clinic_admin
        if ($user->role_id !== 2) {
            return $next($request); // Skip for non-clinic_admin users
        }

        if ($status->status == "inactive") {
            return $next($request);
        }


    

        // Check if the user has agreed to the terms (stored in session)
        if (!session()->has('has_agreed') || !session('has_agreed')) {
            // Prevent redirect loop by checking if the current route is the agreement route
            if ($request->route()->getName() !== 'agreement') {
                return redirect()->route('agreement');
            }
        }

        return $next($request);

    

    }
}
