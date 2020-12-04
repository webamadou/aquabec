<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSlugToSubscription extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if (!Schema::hasTable('subscriptions')) {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->string('slug')->nullable();
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
        if (
          Schema::hasTable('subscriptions')) {
          Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn(['slug']);
          });
        }
    }
}
