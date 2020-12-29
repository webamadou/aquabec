<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditsTransfersLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credits_transfers_logs', function (Blueprint $table) {
            $table->id();
            $table->string("ref",20)->unique();
            $table->foreignId("sent_by");
            $table->foreignId("sent_to");
            $table->integer("credit_type")->unsigned();
            $table->integer("sender_initial_credit")->unsigned();
            $table->integer("recipient_initial_credit")->unsigned();
            $table->integer("sent_value")->unsigned();
            $table->integer("sender_new_credit")->unsigned();
            $table->integer("recipient_new_credit")->unsigned();
            $table->integer("transfer_status")->unsigned();
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
        Schema::dropIfExists('credits_transfers_logs');
    }
}
