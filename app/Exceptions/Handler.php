<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Throwable;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $exception)
    {
        // Tangani kasus autentikasi gagal untuk API
        if ($exception instanceof AuthenticationException) {
            return $request->expectsJson()
                ? response()->json([
                    'status' => false,
                    'message' => 'Unauthenticated',
                ], 401)
                : redirect()->guest(route('login'));
        }

        // Untuk exception lainnya, gunakan handler default
        return parent::render($request, $exception);
    }

    protected function invalidJson($request, ValidationException $exception)
    {
    return response()->json([
            'status' => false,
            'message' => 'Validation errors',
            'errors' => $exception->validator->errors(),
        ], 422);
    }
}
