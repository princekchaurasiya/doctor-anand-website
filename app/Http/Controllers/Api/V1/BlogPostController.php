<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\Repositories\BlogPostRepositoryInterface;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Api\V1\BlogPostResource;
use App\Http\Resources\Api\V1\BlogPostSummaryResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BlogPostController extends ApiController
{
    public function index(BlogPostRepositoryInterface $posts): JsonResponse
    {
        $paginator = $posts->paginatePublished(10);

        return $this->paginated(
            BlogPostSummaryResource::collection($paginator->getCollection()),
            $paginator
        );
    }

    public function show(string $slug, BlogPostRepositoryInterface $posts): JsonResponse
    {
        $post = $posts->findPublishedBySlug($slug);
        if ($post === null) {
            throw new NotFoundHttpException('Blog post not found.');
        }

        return $this->success(new BlogPostResource($post));
    }
}
