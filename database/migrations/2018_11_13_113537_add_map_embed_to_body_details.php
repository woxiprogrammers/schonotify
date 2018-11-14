<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMapEmbedToBodyDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('body_details', function (Blueprint $table) {
            $table->text('map_embed')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('body_details', function (Blueprint $table) {
            $table->dropColumn('map_embed');
        });
    }
}
