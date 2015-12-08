<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHomeworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('homeworks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',255);
            $table->text('description');
            $table->integer('homework_type_id')->unsigned();
            $table->dateTime('homework_timestamp');
            $table->dateTime('due_date');
            $table->integer('subject_id')->unsigned();
            $table->string('attachment_file',255);
            $table->boolean('status');
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
        Schema::drop('homeworks');
    }
}
