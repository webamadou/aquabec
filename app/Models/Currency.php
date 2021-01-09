<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

use App\Models\User;

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
            $user->currencies()->sync([$currency_id]);
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
        $send_by->pivot->save();

       
    }
}
