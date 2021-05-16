<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Cviebrock\EloquentSluggable\Sluggable;

class Faq_group extends Model
{
    use HasFactory;
    use Sluggable;

    protected $guarded = [];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
    */
    public function sluggable()
    {
        return [
            'slug' => [
                 'source'             => ['title'],
                 'separator'          => '-',
                 'unique'             => true,
                 'onUpdate'           => false,
                 'includeTrashed'     => false,
            ]
        ];
    }

    public function page()
    {
        return $this->belongsTo(\App\Models\Page::class);
    }

    public function faqs()
    {
        return $this->hasMany(\App\Models\Faq::class);
    }
}
