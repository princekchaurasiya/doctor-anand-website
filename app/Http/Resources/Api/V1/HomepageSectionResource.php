<?php

namespace App\Http\Resources\Api\V1;

use App\Support\PublicUrl;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\HomepageSection
 */
class HomepageSectionResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'section_key' => $this->section_key,
            'heading' => $this->heading,
            'subheading' => $this->subheading,
            'body' => $this->body,
            'sort_order' => $this->sort_order,
            'image' => PublicUrl::storage($this->image_path),
        ];
    }
}
