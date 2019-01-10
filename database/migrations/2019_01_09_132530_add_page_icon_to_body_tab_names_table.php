<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPageIconToBodyTabNamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('body_tab_names', function (Blueprint $table) {
            $table->string('page_icon',255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('body_tab_names', function (Blueprint $table) {
            $table->dropColumn('page_icon');
        });
    }
}
