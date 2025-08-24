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
        Schema::table('lecturers', function (Blueprint $table) {
            $table->string('structural_position')->nullable()->after('position');
            $table->text('structural_description')->nullable()->after('structural_position');
            $table->date('structural_start_date')->nullable()->after('structural_description');
            $table->date('structural_end_date')->nullable()->after('structural_start_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lecturers', function (Blueprint $table) {
            $table->dropColumn(['structural_position', 'structural_description', 'structural_start_date', 'structural_end_date']);
        });
    }
};
