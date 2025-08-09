<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // Add missing columns
            $table->string('slug')->nullable()->after('name');
            $table->string('place_of_birth')->nullable()->after('gender');
            $table->date('date_of_birth')->nullable()->after('place_of_birth');
            $table->string('parent_name')->nullable()->after('address');
            $table->string('parent_phone')->nullable()->after('parent_name');
            $table->string('school_origin')->nullable()->after('parent_phone');
            
            // Add is_active column based on status
            $table->boolean('is_active')->default(true)->after('status');
            
            // Update gender enum to match the model expectations
            $table->enum('gender', ['L', 'P', 'male', 'female'])->change();
        });
        
        // Update existing data
        DB::statement("UPDATE students SET is_active = CASE WHEN status = 'active' THEN 1 ELSE 0 END");
        DB::statement("UPDATE students SET gender = CASE WHEN gender = 'male' THEN 'L' WHEN gender = 'female' THEN 'P' ELSE gender END");
        
        // Generate slugs for existing students
        $students = DB::table('students')->whereNull('slug')->get();
        foreach ($students as $student) {
            $slug = Str::slug($student->name);
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
            $table->dropColumn([
                'slug',
                'place_of_birth', 
                'date_of_birth',
                'parent_name',
                'parent_phone', 
                'school_origin',
                'is_active'
            ]);
            
            // Revert gender enum
            $table->enum('gender', ['male', 'female'])->change();
        });
    }
};
