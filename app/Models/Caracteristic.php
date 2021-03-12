<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caracteristic extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class);
    }

    public function options()
    {
        return $this->hasMany(\App\Models\CaracteristicOption::class);
    }

    /**
     * Format created date value to custom
     *
     * @param $value
     * @return string
     */
    public function getTypeLabelAttribute($value)
    {
        switch ($value) {
            case 0:
                return "Texte simple";
                break;
            
            case 1:
                return "Choix unique";
                break;
            
            case 2:
                return "Text multiple";
                break;
            
            default:
                return 'Texte simple';
                break;
        }
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
