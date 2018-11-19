<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBodyTabNames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('body_tab_names', function (Blueprint $table) {
            $table->increments('id');
            $table->string('display_name','255');
            $table->string('slug','255');
            $table->unsignedInteger('body_tab_name_id')->nullable();
            $table->unsignedInteger('priority');
            $table->boolean('is_active');
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
        Schema::drop('body_tab_names');
    }
}
