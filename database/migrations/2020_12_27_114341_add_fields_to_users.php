<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn("users", 'paid_credits')){
            Schema::table('users', function (Blueprint $table) {
                $table->integer("paid_credits")->nullable()->default()->unsignedInteger();
            });
        }
        if (!Schema::hasColumn('users', 'free_credits')){
            Schema::table('users', function (Blueprint $table) {
                $table->integer("free_credits")->nullable()->default()->unsignedInteger();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('users', 'free_credits')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn("free_credits");
            });
        }
        if (Schema::hasColumn("users", 'paid_credits')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn("paid_credits");        
            });
        }
    }
}
