<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreditIdToCreditsTransfersLogs extends Migration
{
    public $table = 'credits_transfers_logs';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->table, function (Blueprint $table) {
            if (!Schema::hasColumn($this->table, 'credit_id')){
                Schema::table($this->table, function (Blueprint $table) {
                    $table->integer("credit_id")->after('sent_to')->unsignedInteger();
                });
            }
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
            if (Schema::hasColumn($this->table, 'credit_id')) {
                Schema::table($this->table, function (Blueprint $table) {
                    $table->dropColumn("credit_id");
                });
            }
        });
    }
}
