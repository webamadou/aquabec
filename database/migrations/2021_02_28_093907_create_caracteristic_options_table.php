<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaracteristicOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caracteristic_options', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->foreignId("caracteristic_id");
            $table->string("slug")->nullable(true);
            $table->string("value")->nullable(true);
            $table->text("description")->nullable(true);
            $table->integer("status")->nullable()->default(0);
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
        Schema::dropIfExists('caracteristic_options');
    }
}
