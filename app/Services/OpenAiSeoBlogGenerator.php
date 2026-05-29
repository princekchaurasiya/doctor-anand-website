<?php

namespace App\Services;

use Database\Seeders\BlogLongBodyGenerator;
use Illuminate\Support\Facades\Log;
use OpenAI\Laravel\Facades\OpenAI;

final class OpenAiSeoBlogGenerator
{
    /**
     * @param  array{title: string, category: string, excerpt: string, body?: string, slug: string, focus_keyword?: string}  $post
     */
    public static function generate(array $post): string
    {
        if (blank(config('openai.api_key'))) {
            return BlogLongBodyGenerator::html($post);
        }

        $title = $post['title'];
        $category = $post['category'];
        $excerpt = $post['excerpt'];
        $focusKeyword = $post['focus_keyword'] ?? 'doctor home visit Mumbai';

        $prompt = self::buildPrompt($title, $category, $excerpt, $focusKeyword);

        try {
            $response = OpenAI::chat()->create([
                'model' => env('OPENAI_BLOG_MODEL', 'gpt-4o-mini'),
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are an expert medical SEO writer for Doconnect in Mumbai. Output ONLY valid HTML. No markdown fences. No preamble.',
                    ],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'temperature' => 0.55,
                'max_tokens' => 8000,
            ]);

            $content = $response->choices[0]->message->content ?? '';
            $content = trim((string) $content);
            $content = preg_replace('/^```(?:html)?\s*/i', '', $content) ?? $content;
            $content = preg_replace('/\s*```$/', '', $content) ?? $content;

            if (str_word_count(strip_tags(html_entity_decode($content))) < 400) {
                return BlogLongBodyGenerator::html($post);
            }

            return $content;
        } catch (\Throwable $e) {
            Log::warning('OpenAiSeoBlogGenerator: '.$e->getMessage());

            return BlogLongBodyGenerator::html($post);
        }
    }

    private static function buildPrompt(string $title, string $category, string $excerpt, string $focusKeyword): string
    {
        return <<<PROMPT
You are an expert medical SEO content writer and semantic HTML formatter.

Generate a COMPLETE SEO-optimized blog article in VALID HTML for the Doconnect brand (doctor home visits, nursing, Mumbai).

RULES:
1. Semantic HTML: exactly ONE <h1> with the main title. Multiple <h2> and <h3>. Use <strong> for important SEO terms, <em> for emphasis, <blockquote> for warnings/disclaimers, <ul>/<ol>/<li>, <table> with <thead>/<tbody> where a comparison fits.
2. Minimum 1800 words. Short paragraphs (2–4 sentences). Conversational but professional. No fake statistics. Avoid robotic filler.
3. Primary keyword "{$focusKeyword}" appears naturally in: <h1>, first <p> after <h1>, several <h2>, conclusion. Include semantic / LSI terms: home healthcare, doctor home visit, elder care, Mumbai, emergency consultation, nursing care.
4. Internal linking: naturally link to these paths (use relative URLs): <a href="/">home</a>, <a href="/services">services</a>, <a href="/contact">contact</a>, <a href="/blog">blog</a>.
5. Structure:
   <h1>{$title}</h1>
   <p>Strong SEO intro mentioning Mumbai and Doconnect...</p>
   <h2>Overview</h2> ...
   <h2>Key benefits</h2> <ul>...</ul>
   <h2>When to seek care</h2> <h3>...</h3> ...
   <h2>Practical guidance</h2> (include a <table> comparing at-home vs clinic when relevant)
   <blockquote>Medical disclaimer: educational only; emergencies → ER.</blockquote>
   <h2>Frequently Asked Questions</h2>
   <h3>First question?</h3><p>Answer.</p> (at least 5 FAQ pairs)
   <h2>Conclusion</h2>
   <div class="cta-section"><p>Call Doconnect for a doctor home visit in Mumbai: mention phone +91 84248 45423 and <a href="/contact">request a callback</a>.</p></div>

INPUT:
Title: {$title}
Category: {$category}
Excerpt: {$excerpt}
Primary keyword: {$focusKeyword}
Brand: Doconnect
Location: Mumbai

Return ONLY clean HTML. No markdown. No explanation.
PROMPT;
    }
}
