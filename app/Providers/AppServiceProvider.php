<?php

namespace App\Providers;

use App\Contracts\Repositories\BlogPostRepositoryInterface;
use App\Contracts\Repositories\HomepageSectionRepositoryInterface;
use App\Contracts\Repositories\ServiceRepositoryInterface;
use App\Contracts\Repositories\SiteSettingRepositoryInterface;
use App\Contracts\Services\ContactSubmissionServiceInterface;
use App\Repositories\EloquentBlogPostRepository;
use App\Repositories\EloquentHomepageSectionRepository;
use App\Repositories\EloquentServiceRepository;
use App\Repositories\EloquentSiteSettingRepository;
use App\Models\BlogPost;
use App\Observers\BlogPostObserver;
use App\Services\ContactSubmissionService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SiteSettingRepositoryInterface::class, EloquentSiteSettingRepository::class);
        $this->app->bind(HomepageSectionRepositoryInterface::class, EloquentHomepageSectionRepository::class);
        $this->app->bind(ServiceRepositoryInterface::class, EloquentServiceRepository::class);
        $this->app->bind(BlogPostRepositoryInterface::class, EloquentBlogPostRepository::class);
        $this->app->bind(ContactSubmissionServiceInterface::class, ContactSubmissionService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        BlogPost::observe(BlogPostObserver::class);
    }
}
