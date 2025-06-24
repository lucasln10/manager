<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json(['message' => 'Unauthenticated.'], 401);
    }

    public function render($request, Throwable $exception)
    {
        if ($request->is('api/*') || $request->wantsJson()) {
            $status = 500;
            if (method_exists($exception, 'getStatusCode')) {
                $status = $exception->getStatusCode();
            }
            return response()->json([
                'message' => $exception->getMessage() ?: 'Internal Server Error',
                'exception' => get_class($exception),
            ], $status);
        }

        return parent::render($request, $exception);
    }
}