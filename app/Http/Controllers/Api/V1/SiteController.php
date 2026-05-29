<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\Repositories\SiteSettingRepositoryInterface;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Api\V1\SiteResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SiteController extends ApiController
{
    public function show(SiteSettingRepositoryInterface $sites): JsonResponse
    {
        $site = $sites->first();
        if ($site === null) {
            throw new NotFoundHttpException('Site is not configured yet.');
        }

        return $this->success(new SiteResource($site));
    }
}
