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
        Schema::create('lecturers', function (Blueprint $table) {
            $table->id();
            $table->string('nidn')->unique();
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignId('faculty_id')->constrained()->onDelete('cascade');
            $table->json('study_program_ids')->nullable(); // Multiple study programs
            $table->enum('gender', ['male', 'female']);
            $table->string('title_prefix')->nullable(); // Dr., Prof., etc.
            $table->string('title_suffix')->nullable(); // M.Kom., Ph.D., etc.
            $table->enum('position', ['Asisten Ahli', 'Lektor', 'Lektor Kepala', 'Guru Besar']);
            $table->string('education_background')->nullable();
            $table->text('expertise')->nullable();
            $table->longText('biography')->nullable();
            $table->string('photo')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('office_room')->nullable();
            $table->json('research_interests')->nullable();
            $table->json('publications')->nullable();
            $table->json('awards')->nullable();
            $table->json('certifications')->nullable();
            $table->string('google_scholar')->nullable();
            $table->string('scopus_id')->nullable();
            $table->string('orcid')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['faculty_id', 'position']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecturers');
    }
};
