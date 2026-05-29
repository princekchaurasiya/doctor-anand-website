<?php

namespace App\Http\Controllers\Web;

use App\Contracts\Repositories\ServiceRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\ServiceResource;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ServicePageController extends Controller
{
    public function index(Request $request, ServiceRepositoryInterface $services): Response
    {
        return Inertia::render('Services', [
            'services' => ServiceResource::collection($services->allPublishedOrdered())
                ->resolve($request),
        ]);
    }

    public function show(Request $request, string $slug, ServiceRepositoryInterface $services): Response
    {
        $service = $services->findPublishedBySlug($slug);
        if ($service === null) {
            throw new NotFoundHttpException('Service not found.');
        }

        return Inertia::render('ServiceShow', [
            'service' => (new ServiceResource($service))->resolve($request),
        ]);
    }
}
