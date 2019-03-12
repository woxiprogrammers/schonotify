<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentAnswerSheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_answer_sheets', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('exam_id')->nullable();
            $table->foreign('exam_id')->references('id')->on('exam_evaluation')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('subject_id')->nullable();
            $table->foreign('subject_id')->references('id')->on('subjects')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('student_id')->nullable();
            $table->foreign('student_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('pdf_name',255)->nullable();
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
        Schema::drop('student_answer_sheets');
    }
}
