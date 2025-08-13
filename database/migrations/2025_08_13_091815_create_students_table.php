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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('student_id', 20)->unique(); // NIM
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone', 20)->nullable();
            $table->text('address')->nullable();
            $table->enum('gender', ['male', 'female']);
            $table->date('birth_date');
            $table->string('birth_place');
            $table->unsignedBigInteger('faculty_id');
            $table->unsignedBigInteger('study_program_id');
            $table->string('class')->nullable();
            $table->year('entry_year');
            $table->enum('status', ['active', 'inactive', 'graduated', 'dropped'])->default('active');
            $table->decimal('gpa', 3, 2)->nullable();
            $table->integer('semester')->default(1);
            $table->string('photo')->nullable();
            $table->json('emergency_contact')->nullable();
            $table->json('parent_info')->nullable();
            $table->timestamps();
            
            $table->index(['faculty_id', 'study_program_id']);
            $table->index(['status', 'entry_year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
