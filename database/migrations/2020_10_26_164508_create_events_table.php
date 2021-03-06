<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(false);
            $table->text('description')->nullable(true);
            $table->mediumText('excerpt')->nullable(true);
            $table->string('slug')->nullable(true);
            $table->foreignId('category_id')->nullable(true);
            $table->mediumText('images')->nullable(true);
            $table->foreignId('parent')->nullable(true);
            $table->string('postal_code')->nullable();
            $table->foreignId('posted_by')->nullable(true);
            $table->foreignId('region_id')->nullable(true);
            $table->foreignId('city_id')->nullable(true);
            $table->string('telephone')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->integer('publication_status')->nullable(true)->default(0);
            $table->foreignId('owner')->nullable(false)->comment("If the vendeur save an anoucement for a teamate the owner value will be the id of the teamate");
            $table->dateTime('published_at')->nullable(true);
            $table->mediumText('dates')->nullable(true);
            $table->foreignId('validated_by')->nullable(true);
            $table->dateTime('validated_at')->nullable(true);
            $table->mediumText('rejection_reasons')->nullable(true);
            $table->integer('views')->nullable(true)->default(0);
            $table->integer('clicks')->nullable(true)->default(0);
            $table->integer('spotlight')->nullable(true)->default(0);
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
        Schema::dropIfExists('events');
    }
}
