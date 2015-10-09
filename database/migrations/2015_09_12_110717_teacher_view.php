<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TeacherView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_view', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('teacher_id');
            $table->boolean('mobile_view');
            $table->boolean('web_view');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('teacher_view');
    }
}
