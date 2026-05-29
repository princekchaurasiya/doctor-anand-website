<?php

namespace App\Contracts\Repositories;

use App\Models\BlogPost;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface BlogPostRepositoryInterface
{
    /**
     * @return LengthAwarePaginator<int, BlogPost>
     */
    public function paginatePublished(int $perPage = 10): LengthAwarePaginator;

    public function findPublishedBySlug(string $slug): ?BlogPost;
}
