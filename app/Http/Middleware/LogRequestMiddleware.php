<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class LogRequestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userId = optional($request->user())->id; // get user id if logged in
        $endpoint = $request->path();
        $timestamp = now();

        Log::info("User {$userId} accessed {$endpoint} at {$timestamp}");

        
        return $next($request);
    }
}
