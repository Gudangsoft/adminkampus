<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->string('featured_image')->nullable()->after('content');
            $table->json('meta_data')->nullable()->after('meta_description');
            $table->foreignId('user_id')->nullable()->constrained()->after('meta_data');
            $table->string('template')->nullable()->after('menu_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn(['featured_image', 'meta_data', 'user_id', 'template']);
        });
    }
};
