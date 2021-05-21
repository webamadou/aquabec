<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBloquePublicationToEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            if(!Schema::hasColumn('events', 'lock_publication')){
                $table->integer("lock_publication")->nullable(true)->default(0);
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
        Schema::table('events', function (Blueprint $table) {
            if(Schema::hasColumn('events', 'lock_publication')){
                $table->dropColumn('lock_publication');
            }
        });
    }
}
