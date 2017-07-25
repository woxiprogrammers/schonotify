<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnquiryFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enquiry_form', function (Blueprint $table) {
            $table->increments('id');
            $table->string('guardian_first_name', 255)->nullable();
            $table->string('guardian_middle_name', 255)->nullable();
            $table->string('guardian_last_name', 255)->nullable();
            $table->string('student_first_name', 255)->nullable();
            $table->string('student_middle_name', 255)->nullable();
            $table->string('student_last_name', 255)->nullable();
            $table->date('dob')->nullable();//current_class
            $table->string('current_class', 255)->nullable();
            $table->string('school_name', 255)->nullable();
            $table->string('admission_to_class', 255)->nullable();
            $table->string('mobile_number', 255)->nullable();
            $table->string('address', 255)->nullable();
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
        Schema::drop('enquiry_form');
    }
}
