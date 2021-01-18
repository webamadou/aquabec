<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldNoteToCreditsTransfersLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('credits_transfers_logs', function (Blueprint $table) {
            if(!Schema::hasColumn("credits_transfers_logs", 'notes')){
                $table->text("notes")->after("recipient_new_credit")->nullable(true);
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
        Schema::table('credits_transfers_logs', function (Blueprint $table) {
            if(Schema::hasColumn("credits_transfers_logs", "notes")){
                $table->dropColumn("notes");
            }
        });
    }
}
