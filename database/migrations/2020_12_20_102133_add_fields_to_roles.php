<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->integer("free_events")->nullable(true)->unsigned()->after("name");
            $table->integer("free_annoncements")->nullable(true)->unsigned()->after("free_events");
            $table->integer("events_price")->nullable(true)->unsigned()->after("free_annoncements");
            $table->integer("annoucements_price")->nullable(true)->unsigned()->after("events_price");
            $table->integer("date_credit")->nullable(true)->unsigned()->after("annoucements_price");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn(["free_events","free_annoncements","events_price","annoucements_price","date_credit"]);
        });
    }
}
