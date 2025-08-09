<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

// Create the lecturer_study_programs table
if (!Schema::hasTable('lecturer_study_programs')) {
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
    echo "Table lecturer_study_programs created successfully\n";
} else {
    echo "Table lecturer_study_programs already exists\n";
}
