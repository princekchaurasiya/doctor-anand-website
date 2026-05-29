<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\Repositories\HomepageSectionRepositoryInterface;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Api\V1\HomepageSectionResource;
use Illuminate\Http\JsonResponse;

class HomepageSectionController extends ApiController
{
    public function index(HomepageSectionRepositoryInterface $sections): JsonResponse
    {
        $rows = $sections->allPublishedOrdered();

        return $this->success(HomepageSectionResource::collection($rows));
    }
}
