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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('content');
            $table->text('excerpt')->nullable();
            $table->string('featured_image')->nullable();
            $table->enum('type', ['general', 'academic', 'event', 'urgent'])->default('general');
            $table->enum('status', ['draft', 'active', 'inactive'])->default('draft');
            $table->enum('priority', ['low', 'normal', 'high', 'urgent'])->default('normal');
            $table->unsignedBigInteger('user_id');
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->boolean('is_featured')->default(false);
            $table->boolean('send_notification')->default(false);
            $table->json('target_audience')->nullable(); // JSON array for targeting
            $table->integer('views')->default(0);
            $table->json('meta_data')->nullable();
            $table->timestamps();
            
            $table->index(['status', 'start_date', 'end_date']);
            $table->index(['type', 'priority']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
