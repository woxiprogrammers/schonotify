<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EnquiryFormClg extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('enquiry_form_clg', function (Blueprint $table) {
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
        Schema::drop('enquiry_form_clg');
    }
}
