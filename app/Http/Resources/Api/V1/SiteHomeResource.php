<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Extra site fields used on the homepage only.
 *
 * @mixin \App\Models\SiteSetting
 */
class SiteHomeResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'stats' => $this->stats ?? [],
            'testimonials' => $this->testimonials ?? [],
        ];
    }
}
