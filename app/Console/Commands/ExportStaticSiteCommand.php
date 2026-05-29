<?php

namespace App\Console\Commands;

use App\Models\BlogPost;
use App\Models\Service;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class ExportStaticSiteCommand extends Command
{
    protected $signature = 'site:export-static
                            {--output=static-export : Directory to write the static site}
                            {--base-url=http://127.0.0.1:8000 : Running Laravel app URL}';

    protected $description = 'Export public marketing pages as static HTML for GitHub Pages';

    public function handle(): int
    {
        $output = $this->option('output');
        if (! str_starts_with($output, DIRECTORY_SEPARATOR)) {
            $output = base_path($output);
        }
        $baseUrl = rtrim((string) $this->option('base-url'), '/');

        if (File::isDirectory($output)) {
            File::deleteDirectory($output);
        }

        File::ensureDirectoryExists($output);

        $paths = $this->collectPaths();
        $bar = $this->output->createProgressBar(count($paths));
        $bar->start();

        foreach ($paths as $path) {
            $response = Http::timeout(120)->get($baseUrl.$path);

            if (! $response->successful()) {
                $this->newLine();
                $this->error("Failed {$path}: HTTP {$response->status()}");

                return self::FAILURE;
            }

            $target = $this->targetFile($output, $path);
            File::ensureDirectoryExists(dirname($target));
            File::put($target, $response->body());
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();

        $this->copyPublicAssets($output);
        File::put($output.'/.nojekyll', '');
        File::put($output.'/404.html', File::get($output.'/index.html'));

        $this->info("Static site written to {$output}");

        return self::SUCCESS;
    }

    /**
     * @return list<string>
     */
    private function collectPaths(): array
    {
        $paths = [
            '/',
            '/about',
            '/team',
            '/testimonials',
            '/faqs',
            '/services',
            '/blog',
            '/contact',
        ];

        foreach (Service::query()->where('is_published', true)->orderBy('sort_order')->pluck('slug') as $slug) {
            $paths[] = '/services/'.$slug;
        }

        foreach (BlogPost::query()->where('is_published', true)->orderByDesc('published_at')->pluck('slug') as $slug) {
            $paths[] = '/blog/'.$slug;
        }

        return array_values(array_unique($paths));
    }

    private function targetFile(string $output, string $path): string
    {
        if ($path === '/') {
            return $output.'/index.html';
        }

        return $output.'/'.trim($path, '/').'/index.html';
    }

    private function copyPublicAssets(string $output): void
    {
        if (File::isDirectory(public_path('build'))) {
            File::copyDirectory(public_path('build'), $output.'/build');
        }

        if (File::isDirectory(public_path('storage'))) {
            File::copyDirectory(public_path('storage'), $output.'/storage');
        }

        foreach (File::files(public_path()) as $file) {
            $name = $file->getFilename();
            if (in_array($name, ['index.php', '.htaccess'], true)) {
                continue;
            }

            if ($file->isFile()) {
                File::copy($file->getPathname(), $output.'/'.$name);
            }
        }

        foreach (['css', 'js', 'images'] as $dir) {
            $source = public_path($dir);
            if (File::isDirectory($source)) {
                File::copyDirectory($source, $output.'/'.$dir);
            }
        }
    }
}
