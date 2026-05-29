<?php

namespace App\Contracts\Repositories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Collection;

interface ServiceRepositoryInterface
{
    /**
     * @return Collection<int, Service>
     */
    public function allPublishedOrdered(): Collection;

    public function findPublishedBySlug(string $slug): ?Service;
}
