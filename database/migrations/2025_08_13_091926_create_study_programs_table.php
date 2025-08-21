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
            $table->unsignedBigInteger('faculty_id')->nullable();
            $table->string('degree')->nullable();
            $table->text('description')->nullable();
            $table->string('accreditation')->nullable();
            $table->integer('accreditation_year')->nullable();
            $table->string('head_of_program')->nullable();
            $table->integer('credit_total')->nullable();
            $table->integer('semester_total')->nullable();
            $table->json('career_prospects')->nullable();
            $table->json('facilities')->nullable();
            $table->string('email')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->foreign('faculty_id')->references('id')->on('faculties')->onDelete('set null');
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
