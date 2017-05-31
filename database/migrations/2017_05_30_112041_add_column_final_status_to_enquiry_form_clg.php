<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnFinalStatusToEnquiryFormClg extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('enquiry_form_clg', function (Blueprint $table) {
            $table->text('final_status')->nullable();
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
            $table->dropcolumn('final_status');
        });
    }
}
