<?php

namespace App\Http\Resources\Api\V1;

use App\Support\PublicUrl;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\SiteSetting
 */
class SiteResource extends JsonResource
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
            'service_areas' => $this->service_areas,
            'frontend_public_url' => $this->frontend_public_url,
            'images' => [
                'og' => PublicUrl::storage($this->og_image_path),
            ],
            'open_hours' => $this->open_hours,
            'stats' => $this->stats ?? [],
            'testimonials' => $this->testimonials ?? [],
            'faqs' => $this->faqs ?? [],
            'json_ld' => $this->medicalBusinessJsonLd(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function medicalBusinessJsonLd(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'MedicalBusiness',
            'name' => $this->site_name,
            'description' => $this->meta_description,
            'telephone' => $this->phone,
            'url' => $this->frontend_public_url,
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $this->address_line,
                'addressLocality' => 'Mumbai',
                'addressRegion' => 'Maharashtra',
                'addressCountry' => 'IN',
            ],
        ];
    }
}
