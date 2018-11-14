<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBodySocialDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('body_social_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('body_id');
            $table->foreign('body_id')->references('id')->on('bodies')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedInteger('social_platform_id');
            $table->foreign('social_platform_id')->references('id')->on('social_platform')->onDelete('cascade')->onUpdate('cascade');
            $table->text('name');
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
        Schema::drop('body_social_details');
    }
}
