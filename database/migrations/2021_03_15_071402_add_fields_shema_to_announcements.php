<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsShemaToAnnouncements extends Migration
{
    private $table = "announcements"; 
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->table, function (Blueprint $table) {
            if(!Schema::hasColumn($this->table, "price")){
                $table->string("price",35)->nullable(true)->default("0")->after('description');
            }
            if(!Schema::hasColumn($this->table, "price_type")){
                $table->string("price_type",50)->nullable(true)->after("price");
            }
            if(!Schema::hasColumn($this->table, "event_id")){
                $table->foreignId("event_id",11)->nullable(true)->after("price_type");
            }
            if(!Schema::hasColumn($this->table, "website")){
                $table->string("website",255)->nullable(true)->after('city_id');
            }
            if(!Schema::hasColumn($this->table, "telephone")){
                $table->string("telephone",50)->nullable(true)->after("website");
            }
            if(!Schema::hasColumn($this->table, "email")){
                $table->string("email",150)->nullable(true)->after("website");
            }
            if(!Schema::hasColumn($this->table, "validated")){
                $table->integer("validated")->default(0)->nullable(true)->after("dates");
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
        Schema::table($this->table, function (Blueprint $table) {
            if(Schema::hasColumn($this->table, 'website')){
                $table->dropColumn('website');
            }
            if(Schema::hasColumn($this->table, 'email')){
                $table->dropColumn('email');
            }
            if(Schema::hasColumn($this->table, 'telephone')){
                $table->dropColumn('telephone');
            }

            if(Schema::hasColumn($this->table, 'event_id')){
                $table->dropColumn('event_id');
            }
            if(Schema::hasColumn($this->table, 'price')){
                $table->dropColumn('price');
            }
            if(Schema::hasColumn($this->table, 'price_type')){
                $table->dropColumn('price_type');
            }
            if(Schema::hasColumn($this->table, 'validated')){
                $table->dropColumn('validated');
            }
        });
    }
}
