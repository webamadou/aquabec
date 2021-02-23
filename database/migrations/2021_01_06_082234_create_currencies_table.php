<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('ref',20)->unique();
            $table->string('name', 255);
            $table->string('slug', 255)->nullable();
            $table->text("description")->nullable(true);
            $table->string('icons',60)->nullable(true)->unique();
            $table->integer("status")->default(1)->nullable();
            $table->foreignId("created_by");
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
        Schema::dropIfExists('currencies');
    }
}
