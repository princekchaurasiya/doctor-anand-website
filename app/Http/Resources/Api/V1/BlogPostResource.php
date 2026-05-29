<?php

namespace App\Http\Resources\Api\V1;

use App\Services\BlogBodyFormatter;
use App\Support\PublicUrl;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\BlogPost
 */
class BlogPostResource extends JsonResource
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
            'body' => BlogBodyFormatter::forDisplay($this->body ?? ''),
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'focus_keyword' => $this->focus_keyword,
            'faq_schema' => $this->faq_schema ?? [],
            'table_of_contents' => $this->table_of_contents ?? [],
            'tags' => $this->tags ?? [],
            'published_at' => $this->published_at?->toIso8601String(),
            'image' => PublicUrl::storage($this->featured_image_path),
        ];
    }
}
