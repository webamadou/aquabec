<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\DB;
use Cviebrock\EloquentSluggable\Sluggable;

use App\Models\Currency;
use App\Models\CreditsTransfersLog;

//class User extends Authenticatable
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles;
    use Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //protected $guard_name = 'api';
    protected $guard_name = 'web';

    protected $fillable = [ 'name', 'email', 'password','prenom','region_id','city_id','postal_code','gender','num_civique','street','age_group','mobile_phone','num_tel','godfather' ];
    //protected $guarded = [];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
    */
    public function sluggable()
    {
        return [
            'slug' => [
                 'source'             => ['prenom', 'name'],
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
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function creditsTransfersLogs()
    {
        return $this->hasMany(CreditsTransfersLog::class,'sent_by','id');
    }

    /**
     * 
     * Setting up the relationship between user and region. Each user has a region
     */
    public function region()
    {
        return $this->belongsTo(\App\Models\Region::class);
    }

    /**
     * 
     * Setting up the relationship between user and city. Each user has a city
     */
    public function city()
    {
        return $this->belongsTo(\App\Models\City::class);
    }
    /**
     * 
     * Setting up the relationship between users and currency. A many to many relationship
     */
    public function currencies()
    {
        return $this->belongsToMany(Currency::class)->withPivot('free_currency','paid_currency')->withTimestamps();
    }
    /**
     * 
     * the relation betwin a user and the one that created the account
     */
    public function thegodfather()
    {
        return $this->belongsTo(User::class, 'godfather','id');
    }

    /**
     * 
     * the relation betwin a user and all the accounts he created
     */
    public function godchildren()
    {
        return $this->hasMany(User::class, 'godfather', 'id');
    }

    public function allGodchildren()
    {
        return $this->allGodchildren()->with('allGodchildren');
    }
    
    /**
     * 
     * Get users with role Banquier
     */
    public function scopeBankers($query)
    {
        return $query->whereHas("roles", function($q){ $q->where("name", "Banquier"); } );
    }
    
    /**
     * 
     * Get users with role admin or super-admin
     */
    public function scopeAdmins($query)
    {
        return $query->whereHas("roles", function($q){ $q->where("name", "super-admin")->orWhere('name','admin'); } );
    }
    
    /**
     * 
     * Get users with role chef vendor or vendor
     */
    public function scopeVendors($query)
    {
        return $query->whereHas("roles", function($q){ $q->where('name','chef-vendeur')->orWhere('name','vendeur'); } );
    }
    /**
     * 
     * Get users with role vendor or higher
     */
    public function scopeVendorsHigher($query)
    {
        return $query->whereHas("roles", function($q){ $q->where("name", "admin")
                                                         ->orWhere('name','super-admin')
                                                         ->orWhere('name','Banquier')
                                                         ->orWhere('name','chef vendeur')
                                                         ->orWhere('name','vendeur'); } );
    }
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

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
        /* return Carbon::createFromFormat('Y-m-d H:i:s', $created_at)->format('d-m-Y à H:i:s');
        return $created_at->toDateString().' à '.$created_at->toTimeString(); */
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

    /**
     * return the data of a given currency for a given user
     */
    public function getUserCurrency($currency_id)
    {
        return $this->currencies()
                    ->wherePivot('currency_id',$currency_id)
                    ->first();
    }

    /**
     * set the data of a given currency for a given user
     */
    public function setUserCurrency($currency_id, $pivot_field = [])
    {
        $currency = $this->getUserCurrency($currency_id);
        if($currency == null)
        {//User has no ammount of picked currency
            $this->currencies()->attach([$currency_id => $pivot_field]);
        } else {//we just update the values
            $pivot_field['free_currency'] += $currency->pivot->free_currency;
            $pivot_field['paid_currency'] += $currency->pivot->paid_currency;
            $this->currencies()->updateExistingPivot($currency_id,$pivot_field);
        }

        return $this->getUserCurrency($currency_id);
    }

    /**
     * 
     * assign a role to a user through
     */
    public function giveRole(\App\Models\Role $role)
    {
        if($role === null)
        {return false;}
        //We add a restriction for the banker and super-admin profiles  
        if(strtolower($role->name) === 'banquier' || strtolower($role->name) === 'super-admin'|| strtolower($role->name) === 'admin'|| strtolower($role->name) === 'chef vendeur'){
            return false;
        }
        if($this->hasRole('super-admin')){//We prevent to change the super-admin role
            return false;
        }

        if($this->assignRole($role->name)){
            $free_credit_amount = intval($role->free_credit);
            $paid_credit_amount = intval($role->paid_credit);
            $pivot_fields       = [
                                    'free_currency' => $free_credit_amount,
                                    'paid_currency' => $paid_credit_amount
                                  ];
            $this->setUserCurrency($role->currency_id , $pivot_fields);

            return true;
        }
        return false;
    }
    
}
