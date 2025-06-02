<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class ValidateToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        $token = $request->bearerToken();
        $cleanToken = trim($token, '"');
        $hash = hash('sha256', $cleanToken);
        $user = DB::table('personal_access_tokens')->where('token', $hash)->first();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $request->headers->set('Accept', 'application/json');

        $request->attributes->set('user', $user);

        return $next($request);
        
    }
}
