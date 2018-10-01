<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBodyDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('body_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('logo_name',255)->nullable();
            $table->string('email',255)->nullable();
            $table->string('contact_number',255)->nullable();
            $table->text('address')->nullable();
            $table->unsignedInteger('body_id');
            $table->foreign('body_id')->references('id')->on('bodies')->onDelete('cascade')->onUpdate('cascade');
            $table->text('footer_message')->nullable();
            $table->text('header_message')->nullable();
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
        Schema::drop('body_details');
    }
}
