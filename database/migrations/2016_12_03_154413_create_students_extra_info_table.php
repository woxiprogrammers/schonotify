<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsExtraInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students_extra_info', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('student_id')->unsigned();
            $table->string('grn', 255)->nullable();
            $table->string('birth_place', 255)->nullable();
            $table->string('nationality', 255)->nullable();
            $table->string('religion', 255)->nullable();
            $table->string('caste', 255)->nullable();
            $table->string('category', 255)->nullable();
            $table->text('communication_address');
            $table->string('aadhar_number', 255)->nullable();
            $table->string('blood_group', 255)->nullable();
            $table->string('mother_tongue', 255)->nullable();
            $table->string('other_language', 255)->nullable();
            $table->string('highest_standard', 255)->nullable();
            $table->string('academic_to', 255)->nullable();
            $table->string('academic_from', 255)->nullable();

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
        Schema::drop('students_extra_info');
    }
}
