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
            $table->string('code', 10)->unique();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('faculty_id');
            $table->enum('degree', ['D3', 'S1', 'S2', 'S3'])->default('S1');
            $table->integer('duration_semesters')->default(8); // durasi semester
            $table->string('head_name')->nullable(); // ketua program studi
            $table->string('accreditation', 5)->nullable(); // A, B, C, Unggul, Baik Sekali
            $table->year('accreditation_year')->nullable();
            $table->integer('capacity')->default(0); // kapasitas mahasiswa per tahun
            $table->string('website')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->json('curriculum')->nullable(); // kurikulum dalam JSON
            $table->json('career_prospects')->nullable(); // prospek karir
            $table->timestamps();
            
            $table->foreign('faculty_id')->references('id')->on('faculties')->onDelete('cascade');
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
