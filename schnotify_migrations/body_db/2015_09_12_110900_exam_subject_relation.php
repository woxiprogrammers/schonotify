<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExamSubjectRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_exam_subject_relation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('exam_id');
            $table->integer('subject_id');
            $table->date('date');
            $table->integer('student_id');
            $table->integer('marks');
            $table->integer('out_of_marks');
            $table->boolean('publish_status');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('student_exam_subject_relation');
    }
}
