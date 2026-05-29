<?php

namespace App\Repositories;

use App\Contracts\Repositories\BlogPostRepositoryInterface;
use App\Models\BlogPost;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentBlogPostRepository implements BlogPostRepositoryInterface
{
    public function paginatePublished(int $perPage = 10): LengthAwarePaginator
    {
        return BlogPost::query()
            ->published()
            ->orderByDesc('published_at')
            ->paginate($perPage);
    }

    public function findPublishedBySlug(string $slug): ?BlogPost
    {
        return BlogPost::query()
            ->where('slug', $slug)
            ->published()
            ->first();
    }
}
