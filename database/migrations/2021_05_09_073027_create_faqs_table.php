<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('faq_group_id')->nullable(true);
            $table->string('title');
            $table->mediumText('slug')->nullable();
            $table->longText('content')->nullable(true);
            $table->integer('position')->nullable(true)->default(0);
            $table->integer('publication_status')->nullable(true)->default(0);
            $table->integer('page_id')->nullable(true);
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
        Schema::dropIfExists('faqs');
    }
}
