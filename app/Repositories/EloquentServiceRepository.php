<?php

namespace App\Repositories;

use App\Contracts\Repositories\ServiceRepositoryInterface;
use App\Models\Service;
use Illuminate\Database\Eloquent\Collection;

class EloquentServiceRepository implements ServiceRepositoryInterface
{
    public function allPublishedOrdered(): Collection
    {
        return Service::query()
            ->where('is_published', true)
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();
    }

    public function findPublishedBySlug(string $slug): ?Service
    {
        return Service::query()
            ->where('slug', $slug)
            ->where('is_published', true)
            ->first();
    }
}
