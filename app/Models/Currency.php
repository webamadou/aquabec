<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

use App\Models\User;
use App\Models\Role;
use App\Models\CreditsTransfersLog;

class Currency extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * 
     * Setting up the relationship between users and currency. A many to many relationship
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('free_currency','paid_currency')->withTimestamps();
    }

    /**
     * 
     * Setting up the relationship between CreditsTransfersLog and currency. A many to many relationship
     */
    public function transferslog()
    {
        return $this->hasMany(CreditsTransfersLog::class,'credit_id','id');
    }

    /**
     * 
     * Setting up the relationship between Role and currency. A has many relationship
     */
    public function roles()
    {
        return $this->hasMany(Role::class);
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

    /**
     * return the data of a given currency for a given user
     */
    public function getUserCurrency($user_id, $currency_id)
    {
       return User::find($user_id)
                        ->currencies()
                        ->wherePivot('currency_id',$currency_id)
                        ->first();
    }

    /**
     * set the data of a given currency for a given user
     */
    public function setUserCurrency($user_id, $currency_id)
    {
        $currency = $this->getUserCurrency($user_id, $currency_id);
        if($currency == null)
        {
            $user = User::find($user_id);
            $currency = Currency::find($currency_id);
            $currency->users()->attach([$user_id]);
        }

        return $this->getUserCurrency($user_id, $currency_id);
    }

    /**
     * make the editting necessary to make the transfer.
     * No checking is made  
     * @params $send_by App\Models\Currency objet 
     * @params $send_to App\Models\Currency objet 
     * @params $type string  
     * @params $type integer the amount to transfer 
     */
    public function transfering(Currency $send_by, Currency $send_to, string $type, int $amount)
    {
        $send_by->pivot->$type -= $amount;
        $send_by->pivot->save();

        $send_to->pivot->$type += $amount;
        $send_to->pivot->save();
    }
}
