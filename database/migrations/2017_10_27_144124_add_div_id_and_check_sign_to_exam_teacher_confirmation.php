<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDivIdAndCheckSignToExamTeacherConfirmation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exam_teacher_confirmation', function (Blueprint $table) {
            $table->unsignedInteger('div_id');
            $table->foreign('div_id')->references('id')->on('division')->onUpdated('cascade')->onDelete('cascade');
            $table->unsignedInteger('check_sign');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exam_teacher_confirmation', function (Blueprint $table) {
            $table->drop('exam_teacher_confirmation');
        });
    }
}
