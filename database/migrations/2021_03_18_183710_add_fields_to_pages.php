<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToPages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) {
            if(!Schema::hasColumn('pages','position')){
                $table->string('position')->nullable(true)->after("content");
            }
            if(!Schema::hasColumn('pages','page_type')){
                $table->integer('page_type')->after("position")->nullable(true)->comment("use this to set page type 0 = default; 1=aide ...");
            }
            if(!Schema::hasColumn('pages','custom_link')){
                $table->mediumText('custom_link')->after("page_type")->nullable(true);
            }
            if(!Schema::hasColumn('pages','status')){
                $table->string('status')->after("custom_link")->nullable(true);
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
        Schema::table('pages', function (Blueprint $table) {
            if(Schema::hasColumn('pages','position')){
                $table->dropColumn('position');
            }
            if(Schema::hasColumn('pages','page_type')){
                $table->dropColumn('page_type')->nullable(true)->comment("use this to set page type 0 = default");
            }
            if(Schema::hasColumn('pages','custom_link')){
                $table->dropColumn('custom_link');
            }
            if(Schema::hasColumn('pages','status')){
                $table->dropColumn('status');
            }
        });
    }
}
