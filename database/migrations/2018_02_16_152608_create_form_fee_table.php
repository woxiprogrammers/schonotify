<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormFeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_fee', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('body_id');
            $table->foreign('body_id')->references('id')->on('bodies')->onDelete('cascade')->onUpdate('cascade');
            $table->text('student_name')->nullable();
            $table->text('class')->nullable();
            $table->text('parent_name')->nullable();
            $table->text('sum_of_rupee')->nullable();
            $table->text('transaction_number')->nullable();
            $table->timestamp('date')->nullable();
            $table->text('bank_name')->nullable();
            $table->text('account_holder_name')->nullable();
            $table->text('branch')->nullable();
            $table->text('rupees')->nullable();
            $table->text('balance')->nullable();
            $table->integer('form_fee_id')->nullable();
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
        Schema::drop('form_fee');
    }
}
