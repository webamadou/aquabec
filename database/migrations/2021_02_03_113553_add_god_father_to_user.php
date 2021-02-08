<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGodFatherToUser extends Migration
{
    public $table = "users";
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->table, function (Blueprint $table) {
            if(!Schema::hasColumn($this->table, 'godfather')){
                $table->foreignId("godfather")->nullable('true')->after('remember_token')->comment("The id of the user that registered the user if any");
            }
            if(!Schema::hasColumn($this->table, 'edited_by')){
                $table->foreignId("edited_by")->nullable('true')->after('updated_at');
            }
            if(!Schema::hasColumn($this->table, 'must_update_password')){
                $table->integer("must_update_password")->nullable('true')->default(0)->after('godfather')->comment("This field is use to detect if we must force user to update the password");
            }
            if(!Schema::hasColumn($this->table, 'must_update_password_ref')){
                $table->string("must_update_password_ref",30)->nullable('true')->default(null)->after('must_update_password')->comment("This field is use to save a token value to detect if we should allow change password");
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
            if(Schema::hasColumn($this->table, 'godfather')){
                $table->dropColumn('godfather');
            }
            if(Schema::hasColumn($this->table, 'edited_by')){
                $table->dropColumn('edited_by');
            }
            if(Schema::hasColumn($this->table, 'must_update_password')){
                $table->dropColumn('must_update_password');
            }
            if(Schema::hasColumn($this->table, 'must_update_password_ref')){
                $table->dropColumn('must_update_password_ref');
            }
        });
    }
}
