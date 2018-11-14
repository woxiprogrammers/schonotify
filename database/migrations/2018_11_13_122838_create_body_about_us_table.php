<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBodyAboutUsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('body_about_us', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image_name',255)->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('body_id');
            $table->foreign('body_id')->references('id')->on('bodies')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::drop('body_about_us');
    }
}
