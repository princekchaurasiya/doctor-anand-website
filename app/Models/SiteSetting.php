<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_name',
        'tagline',
        'meta_title',
        'meta_description',
        'phone',
        'whatsapp',
        'email',
        'address_line',
        'service_areas',
        'og_image_path',
        'frontend_public_url',
        'open_hours',
        'stats',
        'testimonials',
        'faqs',
    ];

    protected function casts(): array
    {
        return [
            'stats' => 'array',
            'testimonials' => 'array',
            'faqs' => 'array',
        ];
    }
}
