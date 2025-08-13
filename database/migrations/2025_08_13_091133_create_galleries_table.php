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
            $table->unsignedBigInteger('category_id')->nullable();
            $table->enum('type', ['image', 'video'])->default('image');
            $table->string('file_path');
            $table->string('thumbnail')->nullable();
            $table->string('alt_text')->nullable();
            $table->json('metadata')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->boolean('is_featured')->default(false);
            $table->integer('views')->default(0);
            $table->timestamp('taken_at')->nullable();
            $table->string('photographer')->nullable();
            $table->timestamps();
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
