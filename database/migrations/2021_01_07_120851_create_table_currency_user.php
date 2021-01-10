<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCurrencyUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currency_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId("currency_id");
            $table->foreignId("user_id");
            $table->integer("free_currency")->nullable(true)->default(0);
            $table->integer("paid_currency")->nullable(true)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currency_user');
    }
}
