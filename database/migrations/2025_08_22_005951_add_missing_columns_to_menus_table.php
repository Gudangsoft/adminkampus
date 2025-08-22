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
        Schema::table('menus', function (Blueprint $table) {
            $table->string('icon')->nullable()->after('name');
            $table->string('target', 10)->default('_self')->after('url');
            $table->unsignedBigInteger('page_id')->nullable()->after('url');
            
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropForeign(['page_id']);
            $table->dropColumn(['icon', 'target', 'page_id']);
        });
    }
};
