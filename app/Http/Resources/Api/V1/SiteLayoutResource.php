<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Lightweight site props for header/footer on every page (avoids shipping FAQs/JSON-LD on each request).
 *
 * @mixin \App\Models\SiteSetting
 */
class SiteLayoutResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'site_name' => $this->site_name,
            'tagline' => $this->tagline,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'phone' => $this->phone,
            'whatsapp' => $this->whatsapp,
            'email' => $this->email,
            'address_line' => $this->address_line,
            'open_hours' => $this->open_hours,
        ];
    }
}
