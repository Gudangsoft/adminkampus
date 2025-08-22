<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPositionToLecturersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('lecturers')) {
            return;
        }

        Schema::table('lecturers', function (Blueprint $table) {
            if (!Schema::hasColumn('lecturers', 'position')) {
                $table->string('position')->nullable()->after('photo');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (!Schema::hasTable('lecturers')) {
            return;
        }

        Schema::table('lecturers', function (Blueprint $table) {
            if (Schema::hasColumn('lecturers', 'position')) {
                $table->dropColumn('position');
            }
        });
    }
}
