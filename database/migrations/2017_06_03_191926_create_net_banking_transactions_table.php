<?php
use Illuminate\Database\Schema\Blueprint;

use Illuminate\Database\Migrations\Migration;

class CreateNetBankingTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('net_banking_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('transactions_count');
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
        Schema::drop('net_banking_transactions');
    }
}
