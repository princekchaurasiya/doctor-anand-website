<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Services\BlogPostProcessor;
use App\Services\OpenAiSeoBlogGenerator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DoconnectBlogPostsSeeder extends Seeder
{
    /** @var list<string> */
    private const IMAGE_PALETTE = ['#c8102e', '#9b0d23', '#e63950', '#b30d28', '#d62839', '#a30c20', '#e85d6d', '#8f0a1c'];

    public function run(): void
    {
        /** @var list<array{slug: string, title: string, category: string, excerpt: string, body: string, focus_keyword?: string, tags?: list<string>}> $posts */
        $posts = require __DIR__.'/data/doconnect_blog_posts.php';

        foreach ($posts as $index => $post) {
            $slug = $post['slug'];
            $path = 'seed/blog/posts/'.$slug.'.svg';
            $label = Str::limit($post['title'], 44);
            SeedPlaceholderMedia::put($path, $label, self::IMAGE_PALETTE[$index % count(self::IMAGE_PALETTE)]);

            $focusKeyword = $post['focus_keyword'];
            $tags = $post['tags'];

            $payload = array_merge($post, [
                'slug' => $slug,
                'focus_keyword' => $focusKeyword,
            ]);

            $raw = OpenAiSeoBlogGenerator::generate($payload);
            $body = BlogPostProcessor::sanitize($raw);
            $toc = BlogPostProcessor::extractToc($body);
            $faqs = BlogPostProcessor::extractFaqSchema($body);

            BlogPost::query()->updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $post['title'],
                    'category' => $post['category'],
                    'excerpt' => $post['excerpt'],
                    'body' => $body,
                    'meta_title' => $post['title'].' | Doconnect Mumbai',
                    'meta_description' => Str::limit(strip_tags($post['excerpt']), 155),
                    'focus_keyword' => $focusKeyword,
                    'faq_schema' => $faqs,
                    'table_of_contents' => $toc,
                    'tags' => $tags,
                    'featured_image_path' => $path,
                    'published_at' => now()->subDays(120 - ($index * 4)),
                    'is_published' => true,
                ]
            );
        }
    }
}
