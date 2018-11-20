<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBodyContactUsUserFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('body_contact_us_user_form', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('body_id');
            $table->foreign('body_id')->references('id')->on('bodies')->onDelete('cascade')->onUpdate('cascade');
            $table->string('name',255)->nullable();
            $table->string('slug',255)->nullable();
            $table->boolean('is_active')->nullable();
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
        Schema::drop('body_contact_us_user_form');
    }
}
