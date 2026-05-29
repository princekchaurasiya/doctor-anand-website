<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('open_hours')->nullable()->after('frontend_public_url');
            $table->json('stats')->nullable()->after('open_hours');
            $table->json('testimonials')->nullable()->after('stats');
            $table->json('faqs')->nullable()->after('testimonials');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['open_hours', 'stats', 'testimonials', 'faqs']);
        });
    }
};
