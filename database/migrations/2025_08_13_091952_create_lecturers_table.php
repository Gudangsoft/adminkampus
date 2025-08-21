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
            $table->string('name');
            $table->string('email')->unique();
            $table->unsignedBigInteger('faculty_id')->nullable();
            $table->string('nip')->nullable();
            $table->string('photo')->nullable();
            $table->text('bio')->nullable();
            $table->json('study_program_ids')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('faculty_id')->references('id')->on('faculties')->onDelete('set null');
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
