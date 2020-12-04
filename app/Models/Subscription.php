<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Subscription extends Model
{
    use HasFactory;
    //The table was name subscrptions. But since we want to use laravel cashier, we need to rename the table.
    //The following will help link the new table name to the model.
    protected $table = "subscription_plans";

    protected $fillable = [
        'title', 'credit','price','quota'
    ];

    public function setTitleAttribute($value){
      $this->attributes['title'] = $value;
      $this->attributes['slug'] = Str::of($value)->slug("_");
    }
}
