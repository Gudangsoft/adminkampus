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
        // Add avatar column to users table if not exists
        if (!Schema::hasColumn('users', 'avatar')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('avatar')->nullable()->after('role');
            });
        }

        // Add phone and address to users table if not exists
        if (!Schema::hasColumn('users', 'phone')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('phone', 20)->nullable()->after('avatar');
            });
        }

        if (!Schema::hasColumn('users', 'address')) {
            Schema::table('users', function (Blueprint $table) {
                $table->text('address')->nullable()->after('phone');
            });
        }

        // Add photo and other fields to students table if not exists
        Schema::table('students', function (Blueprint $table) {
            if (!Schema::hasColumn('students', 'slug')) {
                $table->string('slug')->nullable()->after('nim');
            }
            if (!Schema::hasColumn('students', 'email')) {
                $table->string('email')->nullable()->after('slug');
            }
            if (!Schema::hasColumn('students', 'phone')) {
                $table->string('phone', 20)->nullable()->after('email');
            }
            if (!Schema::hasColumn('students', 'address')) {
                $table->text('address')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('students', 'photo')) {
                $table->string('photo')->nullable()->after('address');
            }
            if (!Schema::hasColumn('students', 'date_of_birth')) {
                $table->date('date_of_birth')->nullable()->after('photo');
            }
            if (!Schema::hasColumn('students', 'place_of_birth')) {
                $table->string('place_of_birth')->nullable()->after('date_of_birth');
            }
            if (!Schema::hasColumn('students', 'gender')) {
                $table->enum('gender', ['male', 'female'])->nullable()->after('place_of_birth');
            }
            if (!Schema::hasColumn('students', 'parent_name')) {
                $table->string('parent_name')->nullable()->after('gender');
            }
            if (!Schema::hasColumn('students', 'parent_phone')) {
                $table->string('parent_phone', 20)->nullable()->after('parent_name');
            }
            if (!Schema::hasColumn('students', 'school_origin')) {
                $table->string('school_origin')->nullable()->after('parent_phone');
            }
            if (!Schema::hasColumn('students', 'gpa')) {
                $table->decimal('gpa', 3, 2)->nullable()->after('school_origin');
            }
            if (!Schema::hasColumn('students', 'semester')) {
                $table->integer('semester')->nullable()->after('gpa');
            }
            if (!Schema::hasColumn('students', 'graduation_date')) {
                $table->date('graduation_date')->nullable()->after('semester');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['avatar', 'phone', 'address']);
        });

        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn([
                'slug', 'email', 'phone', 'address', 'photo', 
                'date_of_birth', 'place_of_birth', 'gender',
                'parent_name', 'parent_phone', 'school_origin',
                'gpa', 'semester', 'graduation_date'
            ]);
        });
    }
};
