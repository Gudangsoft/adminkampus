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
        Schema::create('lecturer_study_programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lecturer_id')->constrained()->onDelete('cascade');
            $table->foreignId('study_program_id')->constrained('study_programs')->onDelete('cascade');
            $table->timestamps();
            
            // Ensure unique combination
            $table->unique(['lecturer_id', 'study_program_id']);
            
            // Add indexes for better performance
            $table->index(['lecturer_id']);
            $table->index(['study_program_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecturer_study_programs');
    }
};
