<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBodySliderImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('body_slider_images', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('body_id');
            $table->foreign('body_id')->references('id')->on('bodies')->onDelete('cascade')->onUpdate('cascade');
            $table->string('name',255);
            $table->unsignedInteger('priority')->nullable();
            $table->boolean('is_active');
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
        Schema::drop('body_slider_images');
    }
}
