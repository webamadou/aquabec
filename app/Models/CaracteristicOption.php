<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaracteristicOption extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function caracteristic()
    {
        return $this->belongsTo(\App\Models\Caracteristic::class);
    }


    /**
     * Format created date value to custom
     *
     * @param $value
     * @return string
     */
    public function getCreatedAtAttribute($value)
    {
        $created_at = Carbon::make($value);
        return $created_at->toDateString().' à '.$created_at->toTimeString();
    }

    /**
     * Format updated date value to custom
     *
     * @param $value
     * @return string
     */
    public function getUpdatedAtAttribute($value)
    {
        $updated_at = Carbon::make($value);
        return $updated_at->toDateString().' à '.$updated_at->toTimeString();
    }
}
