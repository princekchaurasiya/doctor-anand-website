<?php

namespace App\Http\Resources\Api\V1;

use App\Support\PublicUrl;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Service
 */
class ServiceResource extends JsonResource
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
            'short_description' => $this->short_description,
            'body' => $this->body,
            'sort_order' => $this->sort_order,
            'image' => PublicUrl::storage($this->featured_image_path),
        ];
    }
}
