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
        // Remove faculty_id from study_programs table
        Schema::table('study_programs', function (Blueprint $table) {
            $table->dropForeign(['faculty_id']);
            $table->dropColumn('faculty_id');
        });

        // Remove faculty_id from lecturers table (if exists)
        if (Schema::hasColumn('lecturers', 'faculty_id')) {
            Schema::table('lecturers', function (Blueprint $table) {
                $table->dropForeign(['faculty_id']);
                $table->dropColumn('faculty_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add faculty_id back to study_programs table
        Schema::table('study_programs', function (Blueprint $table) {
            $table->foreignId('faculty_id')->nullable()->after('id')->constrained()->onDelete('cascade');
        });

        // Add faculty_id back to lecturers table (if exists)
        if (Schema::hasTable('lecturers')) {
            Schema::table('lecturers', function (Blueprint $table) {
                $table->foreignId('faculty_id')->nullable()->after('id')->constrained()->onDelete('cascade');
            });
        }
    }
};
