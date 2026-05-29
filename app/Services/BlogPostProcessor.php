<?php

namespace App\Services;

use Mews\Purifier\Facades\Purifier;

final class BlogPostProcessor
{
    public static function sanitize(string $html): string
    {
        return Purifier::clean($html, 'blog');
    }

    /**
     * @return list<string>
     */
    public static function extractToc(string $html): array
    {
        if (! preg_match_all('/<h2[^>]*>(.*?)<\/h2>/is', $html, $matches)) {
            return [];
        }

        $out = [];
        foreach ($matches[1] as $raw) {
            $text = trim(html_entity_decode(strip_tags($raw), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            if ($text !== '') {
                $out[] = $text;
            }
        }

        return $out;
    }

    /**
     * @return list<array{question: string, answer: string}>
     */
    public static function extractFaqSchema(string $html): array
    {
        if (! preg_match_all('/<h2[^>]*>(.*?)<\/h2>/is', $html, $h2matches, PREG_OFFSET_CAPTURE)) {
            return [];
        }

        $faqStart = null;
        foreach ($h2matches[0] as $idx => $fullPair) {
            $fullStr = $fullPair[0];
            $fullOffset = (int) $fullPair[1];
            $innerPair = $h2matches[1][$idx] ?? ['', 0];
            $inner = is_array($innerPair) ? $innerPair[0] : (string) $innerPair;
            $text = strtolower(trim(html_entity_decode(strip_tags($inner), ENT_QUOTES | ENT_HTML5, 'UTF-8')));
            if (str_contains($text, 'faq') || str_contains($text, 'frequently asked')) {
                $faqStart = $fullOffset + strlen($fullStr);
                break;
            }
        }

        if ($faqStart === null) {
            return [];
        }

        $rest = substr($html, $faqStart);

        if (preg_match('/<h2[^>]*>/i', $rest, $next, PREG_OFFSET_CAPTURE)) {
            $rest = substr($rest, 0, $next[0][1]);
        }

        $faqs = [];
        if (! preg_match_all('/<h3[^>]*>(.*?)<\/h3>\s*<p[^>]*>(.*?)<\/p>/is', $rest, $pairs, PREG_SET_ORDER)) {
            return [];
        }

        foreach ($pairs as $pair) {
            $q = trim(html_entity_decode(strip_tags($pair[1]), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            $a = trim(html_entity_decode(strip_tags($pair[2]), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            if ($q !== '' && $a !== '') {
                $faqs[] = ['question' => $q, 'answer' => $a];
            }
        }

        return $faqs;
    }
}
