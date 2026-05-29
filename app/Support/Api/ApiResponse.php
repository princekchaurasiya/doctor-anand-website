<?php

namespace App\Support\Api;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Single entry point for public API JSON shape: success payloads and errors use the same envelope everywhere.
 */
final class ApiResponse
{
    /**
     * @param  array<string, mixed>|JsonResource  $data
     */
    public static function success(array|JsonResource $data, ?string $message = null, int $status = 200): JsonResponse
    {
        $resolved = $data instanceof JsonResource
            ? $data->resolve(request())
            : $data;

        return response()->json(
            array_filter([
                'success' => true,
                'message' => $message,
                'data' => $resolved,
            ], static fn (mixed $v): bool => $v !== null),
            $status
        );
    }

    /**
     * @param  array<int, array<string, mixed>|object>  $items  Already-resolved resource rows
     * @param  array<string, mixed>  $meta
     */
    public static function paginated(array $items, LengthAwarePaginator $paginator, ?string $message = null): JsonResponse
    {
        return response()->json(
            array_filter([
                'success' => true,
                'message' => $message,
                'data' => $items,
                'meta' => [
                    'current_page' => $paginator->currentPage(),
                    'last_page' => $paginator->lastPage(),
                    'per_page' => $paginator->perPage(),
                    'total' => $paginator->total(),
                ],
            ], static fn (mixed $v): bool => $v !== null)
        );
    }

    public static function created(mixed $data, ?string $message = null): JsonResponse
    {
        return self::success(
            is_array($data) ? $data : ['id' => $data->getKey()],
            $message ?? 'Created',
            201
        );
    }
}
