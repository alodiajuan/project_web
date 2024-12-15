<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$role): Response
    {
        $user = Auth::user();

        if (!$user || !in_array($user->role, $role)) {
            Auth::logout();
            return redirect('/login')->with('error', 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}
