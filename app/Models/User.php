<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\DB;

use App\Models\Currency;
use App\Models\CreditsTransfersLog;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //protected $guard_name = 'api';
    protected $guard_name = 'web';

    protected $fillable = [ 'name', 'email', 'password','prenom','region_id','city_id','postal_code','gender','num_civique','age_group','mobile_phone','num_tel' ];


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
     * Setting up the relationship between users and currency. A many to many relationship
     */
    public function currencies()
    {
        return $this->belongsToMany(Currency::class)->withPivot('free_currency','paid_currency')->withTimestamps();
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
            //dd('hello');
            $this->currencies()->attach([$currency_id => $pivot_field]);
        } else {//we just update the values
            $pivot_field['free_currency'] += $currency->pivot->free_currency;
            $pivot_field['paid_currency'] += $currency->pivot->paid_currency;
            //dd($pivot_field);
            $this->currencies()->updateExistingPivot($currency_id,$pivot_field);
            //$this->currencies()->attach([$currency_id => $pivot_field]);
        }

        return $this->getUserCurrency($currency_id);
    }


}
