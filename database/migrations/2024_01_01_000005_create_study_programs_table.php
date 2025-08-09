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
        Schema::create('study_programs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignId('faculty_id')->constrained()->onDelete('cascade');
            $table->enum('degree', ['D3', 'D4', 'S1', 'S2', 'S3', 'Profesi']);
            $table->text('description')->nullable();
            $table->longText('curriculum')->nullable();
            $table->string('accreditation')->nullable();
            $table->year('accreditation_year')->nullable();
            $table->string('head_of_program')->nullable();
            $table->integer('credit_total')->nullable();
            $table->integer('semester_total')->nullable();
            $table->json('career_prospects')->nullable();
            $table->json('facilities')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->index(['faculty_id', 'degree']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('study_programs');
    }
};
