<?php

namespace App\Http\Responses\Api;

/**
 * Central shape for API error bodies (used by {@see \App\Support\Api\ApiExceptionRenderer}).
 */
final class ApiErrorPayload
{
    /**
     * @param  array<string, array<int, string>>  $errors
     * @return array{success: false, message: string, errors: array<string, array<int, string>>}
     */
    public static function validation(string $message, array $errors): array
    {
        return [
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ];
    }

    /**
     * @return array{success: false, message: string}
     */
    public static function simple(string $message): array
    {
        return [
            'success' => false,
            'message' => $message,
        ];
    }
}
