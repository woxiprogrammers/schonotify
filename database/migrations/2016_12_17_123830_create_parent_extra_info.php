<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParentExtraInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parent_extra_info', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned();
            $table->string('father_first_name', 255)->nullable();
            $table->string('father_middle_name', 255)->nullable();
            $table->string('father_last_name', 255)->nullable();
            $table->string('mother_first_name', 255)->nullable();
            $table->string('mother_middle_name', 255)->nullable();
            $table->string('mother_last_name', 255)->nullable();
            $table->string('father_occupation', 255)->nullable();
            $table->string('father_income', 255)->nullable();
            $table->string('father_contact', 255)->nullable();
            $table->string('mother_occupation', 255)->nullable();
            $table->string('mother_income', 255)->nullable();
            $table->string('mother_contact', 255)->nullable();
            $table->string('parent_email', 255)->nullable();
            $table->string('permanent_address', 255)->nullable();
            $table->string('communication_address', 255)->nullable();
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
        Schema::drop('parent_extra_info');
    }
}
