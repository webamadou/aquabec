<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsSchemaToEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            if(!Schema::hasColumn('events', 'validated')){
                $table->integer('validated')->nullable(true)->default(0);
            }
            if(Schema::hasColumn('events', 'representant_id')){
                $table->foreignId("events", "representant_id");
            }
            $table->mediumText('website')->change()->nullable(true);
            $table->mediumText('description')->change()->nullable(true);
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
            if(Schema::hasColumn('events', 'validated')){
                $table->dropColumn('validated');
            }
            if(Schema::hasColumn('events', 'representant_id')){
                $table->dropColumn("representant_id");
            }
        });
    }
}
