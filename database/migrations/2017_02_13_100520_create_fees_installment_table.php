<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeesInstallmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fee_installments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fee_id')->unsigned();
            $table->integer('installment_id')->unsigned();
            $table->string('particulars_id', 255)->nullable();
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
        Schema::drop('fee_installments');
    }
}
