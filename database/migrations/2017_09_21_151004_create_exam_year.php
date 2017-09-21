<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamYear extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_year', function (Blueprint $table) {
            $table->increments('id');
            $table->text('start_year');
            $table->text('end_year');
            $table->unsignedInteger('exam_structure_id');
            $table->foreign('exam_structure_id')->references('id')->on('exam_sub_subject_structure')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::drop('exam_year');
    }
}
