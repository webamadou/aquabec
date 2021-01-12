<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsCreditsToRoles extends Migration
{
    public $table = 'roles';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->table, function (Blueprint $table) {
            if (!Schema::hasColumn($this->table, 'free_credit') && !Schema::hasColumn($this->table, 'paid_credit') ){
                $table->integer("free_credit")->nullable(true)->default(0)->after('name');
                $table->integer("paid_credit")->nullable(true)->default(0)->after('name');
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
        Schema::table($this->table, function (Blueprint $table) {
            if (Schema::hasColumn($this->table, 'free_credit') && Schema::hasColumn($this->table, 'paid_credit') ){
                $table->dropColumn("free_credit");
                $table->dropColumn("paid_credit");
            }
        });
    }
}
