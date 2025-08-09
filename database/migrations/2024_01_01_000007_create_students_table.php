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
            $table->string('nim')->unique();
            $table->string('name');
            $table->foreignId('study_program_id')->constrained()->onDelete('cascade');
            $table->enum('gender', ['male', 'female']);
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->year('entry_year');
            $table->enum('status', ['active', 'graduate', 'dropout', 'leave'])->default('active');
            $table->string('photo')->nullable();
            $table->decimal('gpa', 3, 2)->nullable();
            $table->integer('semester')->nullable();
            $table->integer('credits_taken')->nullable();
            $table->date('graduation_date')->nullable();
            $table->timestamps();
            
            $table->index(['study_program_id', 'status']);
            $table->index(['entry_year', 'status']);
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
