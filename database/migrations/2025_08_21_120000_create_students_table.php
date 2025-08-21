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
            $table->string('name')->nullable();
            $table->string('nim')->nullable();
            $table->unsignedBigInteger('study_program_id')->nullable();
            $table->year('entry_year')->nullable();
            $table->boolean('is_active')->default(true);
            $table->enum('status', ['active', 'inactive', 'graduate'])->default('active');
            $table->timestamps();

            $table->foreign('study_program_id')->references('id')->on('study_programs')->onDelete('set null');
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
