<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionPaperStructureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_paper_structure', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('question_paper_id');
            $table->foreign('question_paper_id')->references('id')->on('exam_question_paper')->onUpdate('cascade')->onDelete('cascade');
            $table->string('question_id',255)->nullable();
            $table->string('question',255)->nullable();
            $table->unsignedInteger('marks')->nullable();
            $table->unsignedInteger('parent_question_id')->nullable();
            $table->foreign('parent_question_id')->references('id')->on('question_paper_structure')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::drop('question_paper_structure');
    }
}
