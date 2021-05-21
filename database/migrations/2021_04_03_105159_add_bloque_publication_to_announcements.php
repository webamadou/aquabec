<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBloquePublicationToAnnouncements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('announcements', function (Blueprint $table) {
            if(!Schema::hasColumn('announcements', 'lock_publication')){
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
        Schema::table('announcements', function (Blueprint $table) {
            if(Schema::hasColumn('announcements', 'lock_publication')){
                $table->dropColumn('lock_publication');
            }
        });
    }
}
