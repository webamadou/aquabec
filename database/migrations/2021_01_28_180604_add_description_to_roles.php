<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescriptionToRoles extends Migration
{
    public $table = "roles";
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->table, function (Blueprint $table) {
            if(!Schema::hasColumn($this->table, 'description')){
                $table->text("description")->nullable(true);
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
        Schema::table('roles', function (Blueprint $table) {
            if(Schema::hasColumn($this->table, 'description')){
                $table->dropColumn("description");
            }
        });
    }
}
