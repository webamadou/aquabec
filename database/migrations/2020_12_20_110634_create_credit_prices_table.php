<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_prices', function (Blueprint $table) {
            $table->id();
            $table->integer("price")->nullable(false);
            $table->integer("credit_amount")->nullable(false);
            $table->integer("status")->default(1);
            $table->foreignId("role_id")->index()->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('credit_prices');
    }
}
