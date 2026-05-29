<?php

namespace App\Contracts\Repositories;

use App\Models\SiteSetting;

interface SiteSettingRepositoryInterface
{
    public function first(): ?SiteSetting;
}
