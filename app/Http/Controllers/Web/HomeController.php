<?php

namespace App\Http\Controllers\Web;

use App\Contracts\Repositories\HomepageSectionRepositoryInterface;
use App\Contracts\Repositories\ServiceRepositoryInterface;
use App\Contracts\Repositories\SiteSettingRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\HomepageSectionResource;
use App\Http\Resources\Api\V1\ServiceResource;
use App\Http\Resources\Api\V1\SiteHomeResource;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(
        Request $request,
        HomepageSectionRepositoryInterface $sections,
        ServiceRepositoryInterface $services,
        SiteSettingRepositoryInterface $siteSettings,
    ): Response {
        $site = $siteSettings->first();

        return Inertia::render('Home', [
            'homepageSections' => HomepageSectionResource::collection($sections->allPublishedOrdered())
                ->resolve($request),
            'services' => ServiceResource::collection($services->allPublishedOrdered())
                ->resolve($request),
            'siteHome' => $site ? (new SiteHomeResource($site))->resolve($request) : null,
        ]);
    }
}
