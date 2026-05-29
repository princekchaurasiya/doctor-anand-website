<?php

namespace App\Services;

/**
 * Adds presentation classes to stored blog HTML for consistent front-end typography.
 */
final class BlogBodyFormatter
{
    public static function forDisplay(string $html): string
    {
        if ($html === '') {
            return $html;
        }

        $html = preg_replace('/<h2(?!\s[^>]*class=)([^>]*)>/i', '<h2 class="blog-h2"$1>', $html) ?? $html;
        $html = preg_replace('/<h3(?!\s[^>]*class=)([^>]*)>/i', '<h3 class="blog-h3"$1>', $html) ?? $html;

        $leadDone = false;
        $html = preg_replace_callback(
            '/<p(\s[^>]*)?>/i',
            static function (array $m) use (&$leadDone): string {
                if ($leadDone) {
                    return $m[0];
                }
                $leadDone = true;

                return '<p class="blog-lead"'.($m[1] ?? '').'>';
            },
            $html,
            1
        ) ?? $html;

        return $html;
    }
}
