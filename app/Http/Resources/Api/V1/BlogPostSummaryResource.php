<?php

namespace App\Http\Resources\Api\V1;

use App\Support\PublicUrl;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\BlogPost
 */
class BlogPostSummaryResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'category' => $this->category,
            'excerpt' => $this->excerpt,
            'published_at' => $this->published_at?->toIso8601String(),
            'image' => PublicUrl::storage($this->featured_image_path),
            'tags' => $this->tags ?? [],
        ];
    }
}
