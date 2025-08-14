<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('news', function (Blueprint $table) {
            $table->timestamp('scheduled_at')->nullable()->after('published_at');
            $table->enum('status', ['draft', 'scheduled', 'published', 'archived'])
                  ->default('draft')->change();
            $table->boolean('auto_publish')->default(false)->after('scheduled_at');
        });

        Schema::table('announcements', function (Blueprint $table) {
            $table->timestamp('scheduled_at')->nullable()->after('end_date');
            $table->boolean('auto_publish')->default(false)->after('scheduled_at');
        });

        Schema::create('content_schedule', function (Blueprint $table) {
            $table->id();
            $table->morphs('schedulable'); // news_id, announcement_id, etc
            $table->timestamp('scheduled_at');
            $table->enum('action', ['publish', 'unpublish', 'feature', 'unfeature']);
            $table->enum('status', ['pending', 'executed', 'failed']);
            $table->json('metadata')->nullable(); // Additional data for the action
            $table->timestamp('executed_at')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();
            
            $table->index(['scheduled_at', 'status']);
            $table->index(['schedulable_type', 'schedulable_id']);
        });
    }

    public function down()
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn(['scheduled_at', 'auto_publish']);
        });
        
        Schema::table('announcements', function (Blueprint $table) {
            $table->dropColumn(['scheduled_at', 'auto_publish']);
        });
        
        Schema::dropIfExists('content_schedule');
    }
};
