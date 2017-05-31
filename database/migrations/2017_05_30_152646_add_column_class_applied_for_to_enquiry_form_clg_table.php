<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnClassAppliedForToEnquiryFormClgTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('enquiry_form_clg', function (Blueprint $table) {
          $table->text('class_applied')->nullable();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('enquiry_form_clg', function (Blueprint $table) {
          $table->dropcolumn('class_applied');
      });
    }
}
