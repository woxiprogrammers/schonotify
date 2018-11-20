<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTextToBodySliderImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('body_slider_images', function (Blueprint $table) {
            $table->text('message_1')->nullable();
            $table->text('message_2')->nullable();
            $table->string('hyper_name')->nullable();
            $table->text('hyper_link')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('body_slider_images', function (Blueprint $table) {
            $table->dropColumn('message_1');
            $table->dropColumn('message_2');
            $table->dropColumn('hyper_name');
            $table->dropColumn('hyper_link');
        });
    }
}
