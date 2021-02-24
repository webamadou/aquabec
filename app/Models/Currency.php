<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

use App\Models\User;
use App\Models\Role;
use App\Models\CreditsTransfersLog;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate \Support\Str;

class Currency extends Model
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
                 'source'             => 'name',
                 'separator'          => '-',
                 'unique'             => true,
                 'onUpdate'           => true,
                 'includeTrashed'     => false,
            ]
        ];
    }
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
    public function getUserCurrency($user_id)
    {
        return $this->users()->where('user_id',$user_id)->first();
       return User::find($user_id)
                        ->currencies()
                        ->wherePivot('currency_id',$currency_id)
                        ->first();
    }

    /**
     * set the data of a given currency for a given user
     */
    public function setUserCurrency($user_id)
    {
        $currency = $this->getUserCurrency($user_id);
        if($currency == null)
        {
            $user       = User::find($user_id);
            //$currency   = Currency::find($currency_id);
            $this->users()->attach([$user_id]);
        }

        return $this->getUserCurrency($user_id);
    }

    /**
     * make the editting necessary to make the transfer of a currency.
     * No checking is made  
     * @params $send_by App\Models\User objet 
     * @params $send_to App\Models\User objet 
     * @params $type string  
     * @params $type integer the amount to transfer 
     */
    public function transfering(User $send_by, User $send_to, string $type, int $amount)
    {
        $type  = intval($type) > 0 ? 'paid_currency' : 'free_currency';
        $send_by->pivot->$type -= $amount;
        $send_by->pivot->save();

        $send_to->pivot->$type += $amount;
        $send_to->pivot->save();
    }
    
    /**
     * This will handle all chekings before processing the tansfer
     * 
     * @sender object User
     * @recipient object User
     * @currency_type integer the type of credit. 0=free, 1=paid
     * @amount the amount to transfer
     * 
     * 
     */
    public function transferCheckings($sender, $recipient, $currency_type, $amount)
    {
		if( $sender == null || $recipient == null){
            return false;
        }
        //We make sure vendeur , chef vendeur and member can only send paid currency type
        if(!$sender->hasAnyRole(['admin','super-admin','banquier']) && intval($currency_type) === 0){
			return false;
        }
        //Check if sender have enough currency to send
        $currency_type  = intval($currency_type) > 0 ? 'paid_currency' : 'free_currency';
        if(!isset($sender->pivot->$currency_type) || $sender->pivot->$currency_type < $amount){
			return false;
        }
        //Lets make sure sender and recipient are not the same
        if(@$sender->id == @$recipient->id){
			return false;
        }

        return true;
    }

    /**
     * This will take care of transfering the given amount to the user. And process all required changes
     * And will also save to the logs
     * 
     * @sender object User
     * @recipient object User
     * @currency_type integer the type of credit. 0=free, 1=paid
     * @amount the amount to transfer
     * 
     * 
     */
    public function saveTransfer($sender, $recipient, $currency_type, $amount, $notes = null)
    {
        if(!$this->transferCheckings($sender, $recipient, $currency_type, $amount)){
            return false;
        }
        $send_initial_amount        = intval($sender->pivot->$currency_type) ;
        $recipient_initial_amount   = intval($recipient->pivot->$currency_type) ;

        $this->transfering($sender, $recipient, $currency_type, $amount);
        
        //We build the logs
        $logs = [
            'ref' => Str::random(20),
            'sent_by' => $sender->id,
            'sent_to' => $recipient->id,
            'credit_id' => $this->id,
            'credit_type' => $currency_type,
            'sender_initial_credit' => $send_initial_amount,
            'recipient_initial_credit' => $recipient_initial_amount,
            'sent_value' => $amount,
            'sender_new_credit' => $send_initial_amount - intval($amount),
            'recipient_new_credit' => $recipient_initial_amount + intval($amount),
            'notes' => $notes,
            'transfer_status' => 1
        ];
        //Then we save in the log
        $save = \App\Models\CreditsTransfersLog::create($logs);
    }
}
