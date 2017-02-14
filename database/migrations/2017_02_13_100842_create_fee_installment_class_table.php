<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeeInstallmentClassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fee_classes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fee_id')->unsigned();
            $table->integer('class_id')->unsigned();
            $table->string('amount', 255)->nullable();
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
        Schema::drop('caste_concession');
    }
}
