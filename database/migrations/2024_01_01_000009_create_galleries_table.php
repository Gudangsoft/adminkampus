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
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->foreignId('category_id')->constrained('gallery_categories')->onDelete('cascade');
            $table->enum('type', ['image', 'video']);
            $table->string('file_path'); // Path to image or video
            $table->string('thumbnail')->nullable(); // For videos
            $table->string('alt_text')->nullable();
            $table->json('metadata')->nullable(); // File size, dimensions, etc.
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('is_featured')->default(false);
            $table->integer('views')->default(0);
            $table->timestamp('taken_at')->nullable();
            $table->string('photographer')->nullable();
            $table->timestamps();
            
            $table->index(['category_id', 'type']);
            $table->index(['is_featured', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};
