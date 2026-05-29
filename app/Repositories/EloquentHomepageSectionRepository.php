<?php

namespace App\Repositories;

use App\Contracts\Repositories\HomepageSectionRepositoryInterface;
use App\Models\HomepageSection;
use Illuminate\Database\Eloquent\Collection;

class EloquentHomepageSectionRepository implements HomepageSectionRepositoryInterface
{
    public function allPublishedOrdered(): Collection
    {
        return HomepageSection::query()
            ->where('is_published', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();
    }
}
