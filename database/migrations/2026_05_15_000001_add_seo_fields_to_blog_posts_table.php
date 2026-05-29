<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->string('focus_keyword')->nullable()->after('meta_description');
            $table->json('faq_schema')->nullable()->after('focus_keyword');
            $table->json('table_of_contents')->nullable()->after('faq_schema');
            $table->json('tags')->nullable()->after('table_of_contents');
        });
    }

    public function down(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropColumn(['focus_keyword', 'faq_schema', 'table_of_contents', 'tags']);
        });
    }
};
