<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCasteFeeConcessionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caste_concession', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fee_id')->unsigned();
            $table->integer('caste_id')->unsigned();
            $table->string('concession_amount', 255)->nullable();
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
