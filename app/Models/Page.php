<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Carbon\Carbon;

class Page extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = ['title','content','slug','subtitle'];

    public function menu_link(){
        return $this->hasMany(\App\Models\MenuLink::class);
    }

    public function menu(){
        return $this->hasMany(\App\Models\Menu::class);
    }

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
