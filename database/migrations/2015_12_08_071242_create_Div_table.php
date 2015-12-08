<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDivTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('div', function (Blueprint $table) {
            $table->increments('id');
            $table->string('div_name',255);
            $table->integer('class_id')->unsigned();
            $table->integer('class_teacher_id')->unsigned();
            $table->integer('operational_days');
            $table->string('slug',255);
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
        Schema::drop('div');
    }
}
