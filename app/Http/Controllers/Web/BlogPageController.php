<?php

namespace App\Http\Controllers\Web;

use App\Contracts\Repositories\BlogPostRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\BlogPostResource;
use App\Http\Resources\Api\V1\BlogPostSummaryResource;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BlogPageController extends Controller
{
    public function index(Request $request, BlogPostRepositoryInterface $posts): Response
    {
        $paginator = $posts->paginatePublished(10);

        return Inertia::render('Blog', [
            'posts' => BlogPostSummaryResource::collection($paginator->getCollection())->resolve($request),
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
            ],
        ]);
    }

    public function show(Request $request, string $slug, BlogPostRepositoryInterface $posts): Response
    {
        $post = $posts->findPublishedBySlug($slug);
        if ($post === null) {
            throw new NotFoundHttpException('Blog post not found.');
        }

        return Inertia::render('BlogShow', [
            'post' => (new BlogPostResource($post))->resolve($request),
        ]);
    }
}
