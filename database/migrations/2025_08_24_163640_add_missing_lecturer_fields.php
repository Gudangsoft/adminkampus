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
            // Add missing basic fields
            $table->string('nidn')->unique()->after('id');
            $table->string('slug')->unique()->after('name');
            $table->enum('gender', ['male', 'female'])->after('email');
            $table->string('title_prefix')->nullable()->after('gender');
            $table->string('title_suffix')->nullable()->after('title_prefix');
            $table->string('position')->nullable()->after('title_suffix');
            
            // Education and expertise fields
            $table->string('education_background')->nullable()->after('position');
            $table->text('expertise')->nullable()->after('education_background');
            $table->text('biography')->nullable()->after('expertise');
            
            // Contact fields
            $table->string('phone')->nullable()->after('biography');
            $table->string('office_room')->nullable()->after('phone');
            
            // Research fields
            $table->json('research_interests')->nullable()->after('office_room');
            $table->json('publications')->nullable()->after('research_interests');
            $table->json('awards')->nullable()->after('publications');
            $table->json('certifications')->nullable()->after('awards');
            $table->string('google_scholar')->nullable()->after('certifications');
            $table->string('scopus_id')->nullable()->after('google_scholar');
            $table->string('orcid')->nullable()->after('scopus_id');
        });
        
        // Drop old columns in separate statements
        Schema::table('lecturers', function (Blueprint $table) {
            if (Schema::hasColumn('lecturers', 'bio')) {
                $table->dropColumn('bio');
            }
            if (Schema::hasColumn('lecturers', 'nip')) {
                $table->dropColumn('nip');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lecturers', function (Blueprint $table) {
            $table->dropColumn([
                'nidn', 'slug', 'gender', 'title_prefix', 'title_suffix', 'position',
                'education_background', 'expertise', 'biography', 'phone', 'office_room',
                'research_interests', 'publications', 'awards', 'certifications',
                'google_scholar', 'scopus_id', 'orcid'
            ]);
            
            // Restore old fields
            $table->string('nip')->nullable();
            $table->text('bio')->nullable();
        });
    }
};
