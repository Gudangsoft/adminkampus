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
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('type')->nullable();
            $table->string('file_path')->nullable();
            $table->string('thumbnail')->nullable();

            $table->string('alt_text')->nullable();
            $table->string('slug')->nullable();
            $table->string('photographer')->nullable();
            $table->timestamp('taken_at')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('gallery_categories')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
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
