<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamQuestionPaperTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_question_paper', function (Blueprint $table) {
            $table->increments('id');
            $table->string('question_paper_name',255)->nullable();
            $table->unsignedInteger('no_of_question');
            $table->unsignedInteger('marks')->nullable();
            $table->string('set_name',255)->nullable();
            $table->unsignedInteger('exam_id')->nullable();
            $table->foreign('exam_id')->references('id')->on('exam_term_details')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('class_id')->nullable();
            $table->foreign('class_id')->references('id')->on('classes')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::drop('exam_question_paper');
    }
}
