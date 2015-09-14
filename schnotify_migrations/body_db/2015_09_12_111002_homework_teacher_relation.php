<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HomeworkTeacherRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('homework_teacher', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('student_id');
            $table->integer('homework_id');
            $table->integer('teacher_id');
            $table->integer('div_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('homework_teacher');
    }
}
