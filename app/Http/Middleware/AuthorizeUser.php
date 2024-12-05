<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorizeUser
{
    public function handle(Request $request, Closure $next, $roles)
    {
        if (Auth::guard('sdm')->check()) {
            $user = Auth::guard('sdm')->user();
            if ($user->level && $user->level->level_kode == $roles) {
                return $next($request);
            }
        }

        if (Auth::guard('mahasiswa')->check()) {
            $user = Auth::guard('mahasiswa')->user();
            if ($user->level && $user->level->level_kode == $roles) {
                return $next($request);
            }
        }

        return redirect('/')->with('error', 'Unauthorized');
    }
}