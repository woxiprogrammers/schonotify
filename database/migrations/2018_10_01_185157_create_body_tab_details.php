<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBodyTabDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('body_tab_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('body_tab_name_id');
            $table->foreign('body_tab_name_id')->references('id')->on('body_tab_names')->onDelete('cascade')->onUpdate('cascade');
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('body_tab_details');
    }
}
