<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSchemaFieldsTypeToAnnouncement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('announcements', function (Blueprint $table) {
            if(!Schema::hasColumn("announcements", "advertiser_type")){
                $table->string("advertiser_type", 50)->nullable(true)->after("posted_by");
            }
            if(!Schema::hasColumn("announcements", "postal_code")){
                $table->string("postal_code", 50)->nullable(true)->after("telephone");
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
        Schema::table('announcements', function (Blueprint $table) {
            if(Schema::hasColumn("announcements", "advertiser_type")){
                $table->dropColumn("advertiser_type");
            }
            if(Schema::hasColumn("announcements", "postal_code")){
                $table->dropColumn("postal_code");
            }
        });
    }
}
