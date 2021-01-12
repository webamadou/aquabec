<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditCurrencyAmountTypeToCurrencies extends Migration
{

    public $table = 'currency_user';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->table, function (Blueprint $table) {
            $table->bigInteger('free_currency')->nullable(true)->change();
            $table->bigInteger('paid_currency')->nullable(true)->change();
        });
        Schema::table('credits_transfers_logs', function (Blueprint $table) {
            $table->bigInteger('sent_value')->nullable(true)->change();
            $table->bigInteger('sender_initial_credit')->nullable(true)->change();
            $table->bigInteger('recipient_initial_credit')->nullable(true)->change();
            $table->bigInteger('sender_new_credit')->nullable(true)->change();
            $table->bigInteger('recipient_new_credit')->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table($this->table, function (Blueprint $table) {
            $table->bigInteger('free_currency')->nullable(true)->change();
            $table->bigInteger('paid_currency')->nullable(true)->change();
        });
        Schema::table('credits_transfers_logs', function (Blueprint $table) {
            $table->bigInteger('sent_value')->nullable(true)->change();
            $table->bigInteger('sender_initial_credit')->nullable(true)->change();
            $table->bigInteger('recipient_initial_credit')->nullable(true)->change();
            $table->bigInteger('sender_new_credit')->nullable(true)->change();
            $table->bigInteger('recipient_new_credit')->nullable(true)->change();
        });
    }
}
