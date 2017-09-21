<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamTermDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_term_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('exam_structure_id');
            $table->foreign('exam_structure_id')->references('id')->on('exam_sub_subject_structure')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedInteger('term_id');
            $table->foreign('term_id')->references('id')->on('exam_terms')->onDelete('cascade')->onUpdate('cascade');
            $table->string('exam_type',255);
            $table->unsignedInteger('out_of_marks');
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
        Schema::drop('exam_term_details');
    }
}
