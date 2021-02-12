<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class AgeRange extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = ['name','slug','position'];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
    */
    public function sluggable()
    {
        return [
            'slug' => [
                 'source'             => 'name',
                 'separator'          => '-',
                 'unique'             => true,
                 'onUpdate'           => true,
                 'includeTrashed'     => false,
            ]
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
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
        return Carbon::createFromFormat('Y-m-d H:i:s', $created_at)->diffForHumans();
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
        return Carbon::createFromFormat('Y-m-d H:i:s', $updated_at)->diffForHumans();
    }

    public function scopeAgeSelect($query)
    {
        return $query->orderBy('position','asc')->pluck('name','id');
    }

}
