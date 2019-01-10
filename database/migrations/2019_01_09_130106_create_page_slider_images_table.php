<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageSliderImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_slider_images', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('body_tab_name_id');
            $table->foreign('body_tab_name_id')->references('id')->on('body_tab_names')->onDelete('cascade')->onUpdate('cascade');
            $table->string('name',255)->nullable();
            $table->text('message_1')->nullable();
            $table->text('message_2')->nullable();
            $table->string('hyper_name')->nullable();
            $table->text('hyper_link')->nullable();
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
        Schema::drop('page_slider_images');
    }
}
