<?php

namespace App\Repositories;

use App\Contracts\Repositories\SiteSettingRepositoryInterface;
use App\Models\SiteSetting;

class EloquentSiteSettingRepository implements SiteSettingRepositoryInterface
{
    public function first(): ?SiteSetting
    {
        return SiteSetting::query()->first();
    }
}
