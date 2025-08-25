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
            // Basic lecturer fields (excluding position which already exists)
            $table->string('nidn')->nullable()->after('name');
            $table->string('slug')->unique()->nullable()->after('nidn');
            $table->string('gender')->nullable()->after('email');
            $table->string('title_prefix')->nullable()->after('gender');
            $table->string('title_suffix')->nullable()->after('title_prefix');
            
            // Education and expertise
            $table->text('education_background')->nullable()->after('bio');
            $table->text('expertise')->nullable()->after('education_background');
            $table->text('biography')->nullable()->after('expertise');
            
            // Contact information
            $table->string('phone')->nullable()->after('biography');
            $table->string('office_location')->nullable()->after('phone');
            $table->string('office_hours')->nullable()->after('office_location');
            
            // Research and publication
            $table->text('research_interests')->nullable()->after('office_hours');
            $table->json('publications')->nullable()->after('research_interests');
            $table->json('certifications')->nullable()->after('publications');
            
            // Social media
            $table->string('website')->nullable()->after('certifications');
            $table->string('linkedin')->nullable()->after('website');
            $table->string('google_scholar')->nullable()->after('linkedin');
            $table->string('researchgate')->nullable()->after('google_scholar');
        });
        
        // Drop faculty_id separately if it exists
        if (Schema::hasColumn('lecturers', 'faculty_id')) {
            Schema::table('lecturers', function (Blueprint $table) {
                $table->dropColumn('faculty_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lecturers', function (Blueprint $table) {
            // Add faculty_id back
            $table->unsignedBigInteger('faculty_id')->nullable();
            $table->foreign('faculty_id')->references('id')->on('faculties')->onDelete('set null');
            
            // Drop added columns (excluding position and structural fields)
            $table->dropColumn([
                'nidn', 'slug', 'gender', 'title_prefix', 'title_suffix',
                'education_background', 'expertise', 'biography',
                'phone', 'office_location', 'office_hours',
                'research_interests', 'publications', 'certifications',
                'website', 'linkedin', 'google_scholar', 'researchgate'
            ]);
        });
    }
};
