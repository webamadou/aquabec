<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFieldPriceAndAddCreatorFieldsToAnnouncements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->decimal('price',9,2)->change()->nullable(true);
            if(!Schema::hasColumn("announcements",'created_by')){
                $table->foreignId("created_by")->nullable(true);
            }
            if(!Schema::hasColumn("announcements",'updated_by')){
                $table->foreignId("updated_by")->nullable(true);
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
            if(Schema::hasColumn("announcements",'created_by')){
                $table->dropColumn("created_by");
            }
            if(Schema::hasColumn("announcements",'updated_by')){
                $table->dropColumn("updated_by");
            }
        });
    }
}
