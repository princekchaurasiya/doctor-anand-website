<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\Repositories\ServiceRepositoryInterface;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Api\V1\ServiceResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ServiceController extends ApiController
{
    public function index(ServiceRepositoryInterface $services): JsonResponse
    {
        $rows = $services->allPublishedOrdered();

        return $this->success(ServiceResource::collection($rows));
    }

    public function show(string $slug, ServiceRepositoryInterface $services): JsonResponse
    {
        $service = $services->findPublishedBySlug($slug);
        if ($service === null) {
            throw new NotFoundHttpException('Service not found.');
        }

        return $this->success(new ServiceResource($service));
    }
}
