<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamClassStructureRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_class_structure_relation', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('exam_subject_id');
            $table->foreign('exam_subject_id')->references('id')->on('exam_subject_structure')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('class_id');
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade')->onDelete('cascade');
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
        schema::drop('exam_class_structure_relation');
    }
}
