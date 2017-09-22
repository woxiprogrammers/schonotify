<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentExamMarks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_exam_marks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('student_exam_details_id');
            $table->foreign('student_exam_details_id')->references('id')->on('student_exam_details')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedInteger('term_id');
            $table->foreign('term_id')->references('id')->on('exam_terms')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedInteger('exam_structure_id');
            $table->foreign('exam_structure_id')->references('id')->on('exam_sub_subject_structure')->onDelete('cascade')->onUpdate('cascade');
            $table->text('marks_obtained');
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
        Schema::drop('student_exam_details');
    }
}
