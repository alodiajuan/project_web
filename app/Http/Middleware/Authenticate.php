<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo($request): ?string
    {
        // Jika permintaan adalah API, kembalikan respons JSON
        if ($request->expectsJson()) {
            abort(response()->json([
                'status' => false,
                'message' => 'Unauthenticated.',
            ], 401));
        }

        // Jika bukan API, arahkan ke halaman login
        return route('login');
    }
}
