<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Services\BlogPostProcessor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogPostsSeeder extends Seeder
{
    /** @var list<string> */
    private const IMAGE_PALETTE = ['#5B2D8C', '#4A2370', '#7B4BA8', '#6B2FA0', '#8B5FBF', '#3D1F5C', '#9B6FD4', '#E8B923'];

    public function run(): void
    {
        /** @var list<array{slug: string, title: string, category: string, excerpt: string, body: string, focus_keyword: string, tags: list<string>}> $posts */
        $posts = require __DIR__.'/data/blog_posts.php';

        $slugs = array_column($posts, 'slug');
        BlogPost::query()->whereNotIn('slug', $slugs)->delete();

        foreach ($posts as $index => $post) {
            $slug = $post['slug'];
            $path = 'seed/blog/posts/'.$slug.'.svg';
            $label = Str::limit($post['title'], 44);
            SeedPlaceholderMedia::put($path, $label, self::IMAGE_PALETTE[$index % count(self::IMAGE_PALETTE)]);

            $raw = BlogLongBodyGenerator::html($post);
            $body = BlogPostProcessor::sanitize($raw);

            if (BlogLongBodyGenerator::plainTextLength($body) < BlogLongBodyGenerator::MIN_CHARS) {
                throw new \RuntimeException(
                    "Blog post [{$slug}] is under ".BlogLongBodyGenerator::MIN_CHARS.' characters after expansion.'
                );
            }

            $toc = BlogPostProcessor::extractToc($body);
            $faqs = BlogPostProcessor::extractFaqSchema($body);

            BlogPost::query()->updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $post['title'],
                    'category' => $post['category'],
                    'excerpt' => $post['excerpt'],
                    'body' => $body,
                    'meta_title' => $post['title'].' | Satatva Health',
                    'meta_description' => Str::limit(strip_tags($post['excerpt']), 155),
                    'focus_keyword' => $post['focus_keyword'],
                    'faq_schema' => $faqs,
                    'table_of_contents' => $toc,
                    'tags' => $post['tags'],
                    'featured_image_path' => $path,
                    'published_at' => now()->subDays(90 - ($index * 7)),
                    'is_published' => true,
                ]
            );
        }
    }
}
