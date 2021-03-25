<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSchemaFieldsToEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            if(!Schema::hasColumn('events', 'event_time')){
                $table->string('event_time',7)->default('00:00')->nullable(true)->after('dates');
            }
            if(!Schema::hasColumn('events', 'organisation_id')){
                $table->foreignId('organisation_id')->nullable(true)->after('city_id');
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
            if(Schema::hasColumn('events', 'event_time')){
                $table->dropColumn('event_time');
            }
            if(Schema::hasColumn('events', 'organisation_id')){
                $table->dropColumn('organisation_id');
            }
        });
    }
}
