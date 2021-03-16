<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFieldsToPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string("payment_id")->nullable(true)->change();
            $table->string("payment_method")->nullale(true)->change();
            $table->integer("purchassable_id")->nullable(true)->change();
            $table->string("purchassable_type")->nullable(true)->change();
            $table->integer("amount")->nullable(true)->change();
            if(!Schema::hasColumn("payments", 'total_price')){
                $table->integer("total_price")->nullable('true')->after('amount');
            }
            if(!Schema::hasColumn("payments", 'note')){
                $table->mediumText("note")->nullable('true')->after('amount');
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
        Schema::table('payments', function (Blueprint $table) {
            if(Schema::hasColumn("payments", 'total_price')){
                $table->dropColumn("total_price");
            }
            if(Schema::hasColumn("payments", 'note')){
                $table->dropColumn("note");
            }
        });
    }
}
