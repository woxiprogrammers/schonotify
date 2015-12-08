<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id')->unsigned();
            $table->string('username',255);
            $table->integer('body_id')->unsigned();
            $table->string('first_name',255);
            $table->string('last_name',255);
            $table->string('email',255);
            $table->string('gender',10);
            $table->dateTime('birth_date');
            $table->integer('mobile',10);
            $table->string('password',255);
            $table->text('address');
            $table->integer('alternate_number',10);
            $table->integer('parent_id',50);
            $table->integer('roll_number',50);
            $table->string('emp_type',255);
            $table->integer('division_id')->unsigned();
            $table->boolean('is_active');
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
        Schema::drop('users');
    }
}
