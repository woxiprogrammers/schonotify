<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFullPaymentConcessionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('full_payment_concession', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fee_id')->unsigned();
            $table->foreign('fee_id')->references('id')->on('fees')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('concession_type')->unsigned();
            $table->foreign('concession_type')->references('id')->on('full_payment_concession_master')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('student_id')->unsigned()->nullable();
            $table->foreign('student_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('label',255)->nullable();
            $table->integer('amount')->nullable();
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
        Schema::drop('full_payment_concession');
    }
}
