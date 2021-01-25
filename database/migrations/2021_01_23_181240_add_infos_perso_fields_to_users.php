<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInfosPersoFieldsToUsers extends Migration
{
    public $table = "users";
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->table, function (Blueprint $table) {
            if(!Schema::hasColumn($this->table, 'prenom')){
                $table->string("prenom",200)->after("name")->nullable(true);
            }
            if(!Schema::hasColumn($this->table, 'region_id')){
                $table->foreignId("region_id")->after("remember_token")->nullable(true);
            }
            if(!Schema::hasColumn($this->table, 'city_id')){
                $table->foreignId("city_id")->after("region_id")->nullable(true);
            }
            if(!Schema::hasColumn($this->table, 'postal_code')){
                $table->string("postal_code",10)->after("city_id")->nullable(true);
            }
            if(!Schema::hasColumn($this->table, 'num_civique')){
                $table->foreignId("num_civique")->after("postal_code")->nullable(true);
            }
            if(!Schema::hasColumn($this->table, 'street')){
                $table->mediumText("street")->after("num_civique")->nullable(true);
            }
            if(!Schema::hasColumn($this->table, 'age_group')){
                $table->string("age_group",30)->after("street")->nullable(true);
            }
            if(!Schema::hasColumn($this->table, 'gender')){
                $table->integer("gender")->after("age_group")->nullable(true);
            }
            if(!Schema::hasColumn($this->table, 'num_tel')){
                $table->string("num_tel",45)->after("gender")->nullable(true);
            }
            if(!Schema::hasColumn($this->table, 'mobile_phone')){
                $table->string("mobile_phone",45)->after("num_tel")->nullable(true);
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
            if(Schema::hasColumn($this->table, "prenom")){
                $table->dropColumn("prenom");
            }
            if(Schema::hasColumn($this->table, "region_id")){
                $table->dropColumn("region_id");
            }
            if(Schema::hasColumn($this->table, "city_id")){
                $table->dropColumn("city_id");
            }
            if(Schema::hasColumn($this->table, "postal_code")){
                $table->dropColumn("postal_code");
            }
            if(Schema::hasColumn($this->table, "street")){
                $table->dropColumn("street");
            }
            if(Schema::hasColumn($this->table, "age_group")){
                $table->dropColumn("age_group");
            }
            if(Schema::hasColumn($this->table, "num_civique")){
                $table->dropColumn("num_civique");
            }
            if(Schema::hasColumn($this->table, "gender")){
                $table->dropColumn("gender");
            }
            if(Schema::hasColumn($this->table, "num_tel")){
                $table->dropColumn("num_tel");
            }
            if(Schema::hasColumn($this->table, "mobile_phone")){
                $table->dropColumn("mobile_phone");
            }
        });
    }
}
