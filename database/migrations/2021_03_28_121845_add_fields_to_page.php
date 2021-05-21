<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToPage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) {
            if(!Schema::hasColumn('pages','roles')){
                $table->string('roles')->default('')->nullable(true);
            }
            if(!Schema::hasColumn('pages','is_a_separator')){
                $table->string('is_a_separator')->default('')->nullable(true);
            }
            if(!Schema::hasColumn('pages','is_public')){
                $table->integer('is_public')->default(1)->nullable(true)->comment("if 1 menu can be accessed by not autthenticated users");
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
            if(Schema::hasColumn('pages','roles')){
                $table->dropColumn('roles');
            }
            if(Schema::hasColumn('pages','is_a_separator')){
                $table->dropColumn('is_a_separator');
            }
            if(Schema::hasColumn('pages','is_public')){
                $table->dropColumn('is_public');
            }
        });
    }
}
