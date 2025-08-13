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
            $table->string('lecturer_id', 20)->unique(); // NIDN/NIP
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone', 20)->nullable();
            $table->text('address')->nullable();
            $table->enum('gender', ['male', 'female']);
            $table->date('birth_date');
            $table->string('birth_place');
            $table->unsignedBigInteger('faculty_id');
            $table->enum('position', ['asisten_ahli', 'lektor', 'lektor_kepala', 'guru_besar'])->nullable();
            $table->enum('employment_status', ['tetap', 'kontrak', 'honorer'])->default('tetap');
            $table->string('education_level')->nullable(); // S1, S2, S3
            $table->string('specialization')->nullable(); // bidang keahlian
            $table->date('join_date');
            $table->boolean('is_active')->default(true);
            $table->string('photo')->nullable();
            $table->text('biography')->nullable();
            $table->json('research_interests')->nullable(); // minat penelitian
            $table->json('publications')->nullable(); // publikasi
            $table->string('google_scholar')->nullable();
            $table->string('orcid')->nullable();
            $table->timestamps();
            
            $table->foreign('faculty_id')->references('id')->on('faculties')->onDelete('cascade');
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
