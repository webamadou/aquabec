<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Organisation extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = ['name','slug'];


    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
    */
    public function sluggable()
    {
        return [
            'slug' => [
                 'source'             => ['name'],
                 'separator'          => '-',
                 'unique'             => true,
                 'onUpdate'           => true,
                 'includeTrashed'     => false,
            ]
        ];
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

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function getEventsCountAttribute()
    {
        return $this->events()->count();
    }

}
