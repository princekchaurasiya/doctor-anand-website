<?php

namespace App\Support;

final class PublicUrl
{
    public static function basePath(): string
    {
        $base = (string) config('app.static_base', '');

        return $base === '' ? '' : '/'.trim($base, '/');
    }

    public static function storage(?string $path): ?string
    {
        if ($path === null || $path === '') {
            return null;
        }

        // Root-relative URL so assets load on the same host/port as the browser (e.g. 127.0.0.1:8002 vs localhost in APP_URL).
        return self::basePath().'/storage/'.ltrim($path, '/');
    }
}
