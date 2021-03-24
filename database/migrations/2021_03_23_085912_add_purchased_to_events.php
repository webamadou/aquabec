<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPurchasedToEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            if(!Schema::hasColumn('events','purchased')){
                $table->integer('purchased')->nullable()->default(0)->comment("This field will tell if the needed currency were paid or not");
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
        Schema::table('events', function (Blueprint $table) {
            if(Schema::hasColumn('events','purchased')){
                $table->dropColumn('purchased');
            }
        });
    }
}
