<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGradesTable extends Migration
{

    public function up()
    {
        Schema::create('grade', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('class_id');
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade')->onDelete('cascade');
            $table->unsignedInteger('min');
            $table->unsignedInteger('max');
            $table->text('grade');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::table('grade', function (Blueprint $table) {
            $table->drop('grade');
        });
    }
}
