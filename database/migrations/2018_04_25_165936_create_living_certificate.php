<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLivingCertificate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('living_certificate', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('grn');
            $table->text('aadhar_number');
            $table->text('last_school_attented');
            $table->date('date_of_admission');
            $table->text('progress');
            $table->text('conduct');
            $table->date('date_of_leaving');
            $table->text('standard_in_which_studying');
            $table->text('reason');
            $table->text('remark');
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
        Schema::drop('living_certificate');
    }
}
