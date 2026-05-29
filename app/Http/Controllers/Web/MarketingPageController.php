<?php

namespace App\Http\Controllers\Web;

use App\Contracts\Repositories\SiteSettingRepositoryInterface;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class MarketingPageController extends Controller
{
    public function __construct(
        private readonly SiteSettingRepositoryInterface $siteSettings,
    ) {}
    public function about(): Response
    {
        return Inertia::render('About');
    }

    public function team(): Response
    {
        return Inertia::render('Team');
    }

    public function testimonials(): Response
    {
        $site = $this->siteSettings->first();

        return Inertia::render('Testimonials', [
            'testimonials' => $site?->testimonials ?? [],
        ]);
    }

    public function faqs(): Response
    {
        $site = $this->siteSettings->first();

        return Inertia::render('Faqs', [
            'faqs' => $site?->faqs ?? [],
        ]);
    }
}
