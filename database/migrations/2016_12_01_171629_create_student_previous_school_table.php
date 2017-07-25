<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentPreviousSchoolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_previous_school', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('student_id')->unsigned();
            $table->string('school_name', 255)->nullable();
            $table->string('udise_no', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('medium_of_instruction', 255)->nullable();
            $table->string('board_examination', 255)->nullable();
            $table->string('grades', 255)->nullable();
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
        Schema::drop('student_previous_school');
    }
}
