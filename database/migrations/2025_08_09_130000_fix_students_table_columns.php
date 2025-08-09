<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Only add is_active if it doesn't exist
        if (!Schema::hasColumn('students', 'is_active')) {
            Schema::table('students', function (Blueprint $table) {
                $table->boolean('is_active')->default(true)->after('status');
            });
            
            // Update existing data - set is_active based on status
            DB::statement("UPDATE students SET is_active = CASE WHEN status = 'active' THEN 1 ELSE 0 END");
        }

        // Add other missing columns if they don't exist
        Schema::table('students', function (Blueprint $table) {
            if (!Schema::hasColumn('students', 'slug')) {
                $table->string('slug')->nullable()->after('name');
            }
            if (!Schema::hasColumn('students', 'place_of_birth')) {
                $table->string('place_of_birth')->nullable()->after('gender');
            }
            if (!Schema::hasColumn('students', 'date_of_birth')) {
                $table->date('date_of_birth')->nullable()->after('place_of_birth');
            }
            if (!Schema::hasColumn('students', 'parent_name')) {
                $table->string('parent_name')->nullable()->after('address');
            }
            if (!Schema::hasColumn('students', 'parent_phone')) {
                $table->string('parent_phone')->nullable()->after('parent_name');
            }
            if (!Schema::hasColumn('students', 'school_origin')) {
                $table->string('school_origin')->nullable()->after('parent_phone');
            }
        });

        // Generate slugs for students that don't have them
        $students = DB::table('students')->whereNull('slug')->get();
        foreach ($students as $student) {
            $slug = \Illuminate\Support\Str::slug($student->name);
            $counter = 1;
            $originalSlug = $slug;
            
            while (DB::table('students')->where('slug', $slug)->where('id', '!=', $student->id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            
            DB::table('students')->where('id', $student->id)->update(['slug' => $slug]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $columns = ['is_active', 'slug', 'place_of_birth', 'date_of_birth', 'parent_name', 'parent_phone', 'school_origin'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('students', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
