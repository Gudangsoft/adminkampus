<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddViewsToGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('galleries')) {
            return;
        }

        Schema::table('galleries', function (Blueprint $table) {
            if (!Schema::hasColumn('galleries', 'views')) {
                // store as unsigned big integer to be safe for large counts
                $table->unsignedBigInteger('views')->default(0)->after('updated_at');
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
        if (!Schema::hasTable('galleries')) {
            return;
        }

        Schema::table('galleries', function (Blueprint $table) {
            if (Schema::hasColumn('galleries', 'views')) {
                $table->dropColumn('views');
            }
        });
    }
}
