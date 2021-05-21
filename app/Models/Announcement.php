<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Carbon\Carbon;  

class Announcement extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = [
        'title', 'description', 'excerpt', 'slug', 'category_id', 'images', 'parent', 'posted_by', 'region_id', 'city_id', 'publication_status', 'owner', 'published_at', 'dates','purchased','price_type','price','email','telephone','postal_code','event_id','advertiser_type'
    ];
    protected $appends = ['advertiser'];

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

    public function event()
    {
        return $this->belongsTo(\App\Models\Event::class);
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

    public function getAdvertiserAttribute(){
        switch (intval($this->advertiser_type)) {
            case 1:
                return "particulier";
                break;
            case 'value':
                return "commerce";
                break;
            
            default:
                "";
                break;
        }
    }

    public function getImagesAttribute($value)
    {
        if($value === null )
            return 'default-image.jpg';
        
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
        return Carbon::createFromFormat('Y-m-d H:i:s', $created_at)->format('d-m-Y à H:i:s');
    }
/* 
    public function getPublishedAtAttribute($value)
    {
        if($value === null)
        return " --- ";
        $published_at = Carbon::make($value);
        return Carbon::createFromFormat('Y-m-d H:i:s', $published_at)->diffForHumans();
    } */
    /**
     * Format updated date value to custom
     *
     * @param $value
     * @return string
     */
    public function getUpdatedAtAttribute($value)
    {
        $updated_at = Carbon::make($value);
        return Carbon::createFromFormat('Y-m-d H:i:s', $updated_at)->format('d-m-Y à H:i:s');
    }

    /**
     * Format the price
     */
    public static function formatPrice($value)
    {
        $returned_ref = '';
        $ref = str_split($value);
        $i = 0;
        for ($c = count($ref) - 1; $c >= 0 ; $c--) {
            $returned_ref = ($i % 3) === 0 ? @$ref[$c]." ".$returned_ref : @$ref[$c].$returned_ref;
            $i++;
        }
        return $returned_ref;
    }
    public function getPrice()
    {
        switch (intval($this->price_type)) {
            case 1:
                return "$".self::formatPrice($this->price);
                break;
            case 2:
                return "Échange";
                break;
            case 3:
                return "Gratuit";
                break;
            
            default:
                return "Non Précisé";
                break;
        }
    }


    public function countViews(){
        $this->views += 1;
        $this->save();
    }

    public function countClicks(){
        $this->clicks += 1;
        $this->save();
    }

}
