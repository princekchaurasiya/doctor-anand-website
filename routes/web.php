<?php

use App\Http\Controllers\Web\BlogPageController;
use App\Http\Controllers\Web\ContactPageController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\MarketingPageController;
use App\Http\Controllers\Web\ServicePageController;
use App\Http\Middleware\HandleInertiaRequests;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Route;

/*
| Public site routes below require no login. Admin uses Filament at /admin/login.
| Named route "login" so /login and route('login') resolve for staff bookmarks.
*/

Route::get('/login', function () {
    $url = Filament::getPanel('admin')->getLoginUrl();

    return redirect()->to($url ?? '/admin/login');
})->name('login');

// Plain HTML test (no JavaScript) — keep until full site is verified
Route::get('/debug-plain', fn () => view('home-debug'));

Route::middleware([HandleInertiaRequests::class])->group(function (): void {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/about', [MarketingPageController::class, 'about'])->name('about');
    Route::get('/team', [MarketingPageController::class, 'team'])->name('team');
    Route::get('/testimonials', [MarketingPageController::class, 'testimonials'])->name('testimonials');
    Route::get('/faqs', [MarketingPageController::class, 'faqs'])->name('faqs');
    Route::get('/services', [ServicePageController::class, 'index'])->name('services.index');
    Route::get('/services/{slug}', [ServicePageController::class, 'show'])->name('services.show');
    Route::get('/blog', [BlogPageController::class, 'index'])->name('blog.index');
    Route::get('/blog/{slug}', [BlogPageController::class, 'show'])->name('blog.show');
    Route::get('/contact', [ContactPageController::class, 'show'])->name('contact.show');
    Route::post('/contact', [ContactPageController::class, 'store'])->name('contact.store');
});
