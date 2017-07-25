<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStartEndMonthDateToBodiesTable extends Migration
{
    public function up()
    {
        Schema::table('bodies', function (Blueprint $table) {
            $table->string('start_month',255)->after('logo');
            $table->string('end_month',255)->after('start_month');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bodies', function (Blueprint $table) {
            $table->dropColumn('start_month');
            $table->dropColumn('end_month');
        });
    }
}
