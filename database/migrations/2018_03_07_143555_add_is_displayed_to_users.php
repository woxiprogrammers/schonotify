<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsDisplayedToUsers extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
           $table->boolean('is_displayed')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_displayed');
        });
    }
}
