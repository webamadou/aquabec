<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id','type','name','slug'
    ];

    /**
     * 
     * the relation betwin a category and its parent
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id','id');
    }

    /**
     * 
     * the relation betwin a category and its children
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }

    public function getCategoriesCountAttribute()
    {
        return $this->children()->count();
    }

    public function getEventsCountAttribute()
    {
        return $this->events()->count();
    }

    public function getAnnouncementsCountAttribute()
    {
        return $this->announcements()->count();
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
