<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Support\Api\ApiResponse;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Thin base for API controllers: delegates response shape to ApiResponse (DRY).
 */
abstract class ApiController extends Controller
{
    protected function success(array|JsonResource $data, ?string $message = null, int $status = 200): JsonResponse
    {
        return ApiResponse::success($data, $message, $status);
    }

    protected function paginated(JsonResource $collectionResource, LengthAwarePaginator $paginator, ?string $message = null): JsonResponse
    {
        $items = $collectionResource->resolve(request());

        return ApiResponse::paginated($items, $paginator, $message);
    }

    protected function created(mixed $data, ?string $message = null): JsonResponse
    {
        return ApiResponse::created($data, $message);
    }
}
