<?php
// database/migrations/2025_08_21_000001_create_tags_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        Schema::create('news_tag', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('news_id');
            $table->unsignedBigInteger('tag_id');
            $table->foreign('news_id')->references('id')->on('news')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
            $table->unique(['news_id', 'tag_id']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('news_tag');
        Schema::dropIfExists('tags');
    }
};
