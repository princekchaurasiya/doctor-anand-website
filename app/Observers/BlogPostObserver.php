<?php

namespace App\Observers;

use App\Models\BlogPost;
use App\Services\BlogPostProcessor;

class BlogPostObserver
{
    public function saving(BlogPost $post): void
    {
        if (! $post->isDirty('body')) {
            return;
        }

        $body = (string) $post->body;
        $post->body = BlogPostProcessor::sanitize($body);
        $post->table_of_contents = BlogPostProcessor::extractToc($post->body);
        $post->faq_schema = BlogPostProcessor::extractFaqSchema($post->body);
    }
}
