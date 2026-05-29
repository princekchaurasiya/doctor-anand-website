<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Storage;

/**
 * Writes lightweight SVG placeholders into the public disk for local/demo content.
 */
final class SeedPlaceholderMedia
{
    public static function put(string $relativePath, string $label, string $backgroundHex = '#0d5c6b'): void
    {
        $safe = htmlspecialchars($label, ENT_XML1 | ENT_COMPAT, 'UTF-8');
        $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="1200" height="630" viewBox="0 0 1200 630">
  <rect width="1200" height="630" fill="{$backgroundHex}"/>
  <text x="600" y="315" fill="#ffffff" font-family="system-ui,Segoe UI,sans-serif" font-size="42" font-weight="600" text-anchor="middle" dominant-baseline="middle">{$safe}</text>
</svg>
SVG;

        Storage::disk('public')->put($relativePath, $svg);
    }
}
