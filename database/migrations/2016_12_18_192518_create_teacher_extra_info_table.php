<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeacherExtraInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_extra_info', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('teacher_id')->unsigned();
            $table->string('martial_status', 255)->nullable();
            $table->string('spouse_first_name', 255)->nullable();
            $table->string('spouse_middle_name', 255)->nullable();
            $table->string('spouse_last_name', 255)->nullable();
            $table->string('issues', 255)->nullable();

            $table->string('permanent_address', 255)->nullable();
            $table->string('communication_address', 255)->nullable();
            $table->string('aadhar_number', 255)->nullable();
            $table->string('pan_card', 255)->nullable();
            $table->string('designation', 255)->nullable();
            $table->date('joining_date')->nullable();
            $table->string('b_ed_methods', 255)->nullable();
            $table->string('total_work_experience', 255)->nullable();
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
        Schema::drop('teacher_extra_info');
    }
}
