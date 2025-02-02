<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\facades\JWTAuth;
use Illuminate\Http\Request;

class JWT
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
        JWTAuth::parseToken()->authenticate(); 
        return $next($request);
    } 
}
