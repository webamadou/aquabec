<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Event extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = [
        'title', 'description', 'excerpt', 'slug', 'category_id', 'images', 'parent', 'posted_by','postal_code', 'region_id', 'city_id', 'publication_status', 'owner', 'published_at', 'dates','telephone', 'website',
        'email','purchased','event_time','organisation_id'
    ];
    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
    */
    public function sluggable()
    {
        return [
            'slug' => [
                'source'             => 'title',
                'separator'          => '-',
                'unique'             => true,
                'onUpdate'           => false,
                'includeTrashed'     => false,
            ]
        ];
    }

    public function announcement()
    {
        return $this->hasOne(\App\Models\Announcement::class);
    }
    public function region()
    {
        return $this->belongsTo(\App\Models\Region::class);
    }

    public function city()
    {
        return $this->belongsTo(\App\Models\City::class);
    }

    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class);
    }

    public function posted()
    {
        return $this->belongsTo(\App\Models\User::class, 'posted_by', 'id' );
    }

    public function owned()
    {
        return $this->belongsTo(\App\Models\User::class,'owner','id');
    }

    public function validated()
    {
        return $this->belongsTo(\App\Models\User::class, 'validated_by', 'id');
    }

    public function organisation()
    {
        return $this->belongsTo(\App\Models\Organisation::class);
    }

    public function getImagesAttribute($value)
    {
        if($value === null )
            return 'default.jpg';
        
        return $value;
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

    /* public function getPublishedAtAttribute($value)
    {
        if($value === null)
        return " --- ";
        $published_at = Carbon::make($value);
        return Carbon::createFromFormat('Y-m-d H:i:s', $published_at)->diffForHumans();
    } */

    public function countViews(){
        $this->views += 1;
        $this->save();
    }

    public function countClicks(){
        $this->clicks += 1;
        $this->save();
    }
}
