<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSyEnquiryFormClg extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Sy_Enquiry_Form_Clg', function (Blueprint $table) {
            $table->increments('id');
            $table->text('form_no');
            $table->text('medium');
            $table->text('first_name');
            $table->text('middle_name');
            $table->text('last_name');
            $table->integer('marks_obtained')->unsigned();
            $table->integer('outOf_marks')->unsigned();
            $table->integer('percentage')->unsigned();
            $table->text('board');
            $table->text('caste');
            $table->text('country');
            $table->text('state');
            $table->text('category');
            $table->text('examination_year');
            $table->text('date');
            $table->string('mobile');
            $table->text('address');
            $table->text('class_applied');
            $table->string('ssc_certificate',512);
            $table->string('hsc_certificate',512);
            $table->string('caste_certificate',512);
            $table->text('email');
            $table->text('diff_category');
            $table->text('final_status');
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
        Schema::drop('Sy_Enquiry_Form_Clg');
    }
}
