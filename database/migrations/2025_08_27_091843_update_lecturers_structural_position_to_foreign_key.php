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
            // Hapus kolom structural_position lama jika ada
            if (Schema::hasColumn('lecturers', 'structural_position')) {
                $table->dropColumn('structural_position');
            }
            
            // Tambah foreign key ke structural_positions
            $table->foreignId('structural_position_id')->nullable()->after('is_active')->constrained('structural_positions')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lecturers', function (Blueprint $table) {
            // Hapus foreign key constraint dan kolom
            $table->dropForeign(['structural_position_id']);
            $table->dropColumn('structural_position_id');
            
            // Kembalikan kolom structural_position lama
            $table->string('structural_position')->nullable()->after('is_active');
        });
    }
};
