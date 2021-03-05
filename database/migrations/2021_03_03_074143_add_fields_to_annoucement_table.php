<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToAnnoucementTable extends Migration
{
    public $table = 'announcements';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->table, function (Blueprint $table) {
            $table->string('title')->after('id')->nullable(false);
            $table->text('description')->after('title')->nullable(true);
            $table->mediumText('excerpt')->after('description')->nullable(true);
            $table->string('slug')->after('excerpt')->nullable(true);
            $table->foreignId('category_id')->change()->nullable(false);
            $table->mediumText('images')->after('category_id')->nullable(true);
            $table->foreignId('parent')->after('images')->nullable(true);
            $table->foreignId('posted_by')->after('parent')->nullable(true);
            $table->foreignId('region_id')->after('posted_by')->nullable(true);
            $table->foreignId('city_id')->after('posted_by')->nullable(true);
            $table->integer('publication_status')->after('city_id')->nullable(true)->default(0);
            $table->foreignId('owner')->after('publication_status')->nullable(false)->comment("If the vendeur save an anoucement for a teamate the owner value will be the id of the teamate");
            $table->dateTime('published_at')->after('owner')->nullable(true);
            $table->mediumText('dates')->after('published_at')->nullable(true);
            $table->foreignId('validated_by')->after('dates')->nullable(true);
            $table->dateTime('validated_at')->after('validated_by')->nullable(true);
            $table->mediumText('rejection_reasons')->after('validated_at')->nullable(true);
            $table->integer('views')->after('rejection_reasons')->nullable(true)->default(0);
            $table->integer('clicks')->after('views')->nullable(true)->default(0);
            $table->integer('spotlight')->after('clicks')->nullable(true)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table($this->table, function (Blueprint $table) {
            $table->dropColumn([
                                'title',
                                'description',
                                'excerpt',
                                'slug',
                                'images',
                                'parent',
                                'posted_by',
                                'region_id',
                                'city_id',
                                'publication_status',
                                'owner',
                                'published_at',
                                'dates',
                                'validated_by',
                                'validated_at',
                                'rejection_reasons',
                                'views',
                                'clicks',
                                'spotlight',
                            ]);
        });
    }
}
