<?php

use App\Http\Controllers\Api\V1\BlogPostController;
use App\Http\Controllers\Api\V1\ContactController;
use App\Http\Controllers\Api\V1\HomepageSectionController;
use App\Http\Controllers\Api\V1\ServiceController;
use App\Http\Controllers\Api\V1\SiteController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function (): void {
    Route::get('/site', [SiteController::class, 'show']);
    Route::get('/homepage', [HomepageSectionController::class, 'index']);
    Route::get('/services', [ServiceController::class, 'index']);
    Route::get('/services/{slug}', [ServiceController::class, 'show']);
    Route::get('/blog', [BlogPostController::class, 'index']);
    Route::get('/blog/{slug}', [BlogPostController::class, 'show']);
    Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:5,1');
});
