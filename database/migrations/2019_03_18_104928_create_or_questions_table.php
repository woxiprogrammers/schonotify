<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('or_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('question_id')->nullable();
            $table->foreign('question_id')->references('id')->on('question_paper_structure')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('or_question_id')->nullable();
            $table->foreign('or_question_id')->references('id')->on('question_paper_structure')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::drop('or_questions');
    }
}
