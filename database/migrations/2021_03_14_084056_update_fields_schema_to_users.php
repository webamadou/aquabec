<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFieldsSchemaToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if(!Schema::hasColumn('users', 'username')){
                $table->string("username")->nullable('true')->after('name');
            }
            if(!Schema::hasColumn('users', 'last_seen')){
                $table->date("last_seen")->nullable('true')->after('updated_at');
            }
            if(!Schema::hasColumn('users', 'avatar')){
                $table->string("avatar")->nullable('true')->after('username');
            }
            $table->string("num_civique",255)->nullable(true)->change();
            $table->string("postal_code",15)->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if(Schema::hasColumn('users', 'username')){
                $table->dropColumn("username");
            }
            if(Schema::hasColumn('users', 'last_seen')){
                $table->dropColumn("last_seen");
            }
            if(Schema::hasColumn('users', 'avatar')){
                $table->dropColumn("avatar");
            }
        });
    }
}
