<?php

namespace App\Support\Api;

use App\Http\Responses\Api\ApiErrorPayload;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

/**
 * Central API error envelope. Used once from bootstrap; all /api/* errors share the same JSON contract.
 */
final class ApiExceptionRenderer
{
    public static function render(Request $request, Throwable $e): ?JsonResponse
    {
        if (! $request->is('api/*')) {
            return null;
        }

        if ($e instanceof ValidationException) {
            return response()->json(
                ApiErrorPayload::validation($e->getMessage(), $e->errors()),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        if ($e instanceof ModelNotFoundException) {
            return response()->json(
                ApiErrorPayload::simple('Resource not found.'),
                Response::HTTP_NOT_FOUND
            );
        }

        if ($e instanceof AuthenticationException) {
            return response()->json(
                ApiErrorPayload::simple('Unauthenticated.'),
                Response::HTTP_UNAUTHORIZED
            );
        }

        if ($e instanceof HttpExceptionInterface) {
            $status = $e->getStatusCode();
            $message = $e->getMessage();
            if ($message === '') {
                $message = Response::$statusTexts[$status] ?? 'Request error';
            }

            return response()->json(
                ApiErrorPayload::simple($message),
                $status
            );
        }

        report($e);

        $message = config('app.debug') ? $e->getMessage() : 'Server error.';

        return response()->json(
            ApiErrorPayload::simple($message),
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }
}
