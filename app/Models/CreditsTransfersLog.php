<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class CreditsTransfersLog extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['free_currency'];

    /**
     * Return either "payant" or "gratuit" depending on the credit_type column
     * 
     * 
     */
    public function getCreditTypeAttribute()
    {
        $type = @$this->attributes["credit_type"] > 0 ? "Payant" : "Gratuit";
        return $type;
    }
    /**
     * the relation between the log and the sender
     */
    public function sentBy()
    {
        return $this->belongsTo(User::class,'sent_by', 'id');
    }
    /**
     * the relation between the log and the recipient
     */
    public function sentTo()
    {
        return $this->belongsTo(User::class,'sent_to', 'id');
    }

    /**
     * the relation between the log and the recipient
     */
    public function credit()
    {
        return $this->belongsTo(\App\Models\Currency::class,'credit_id', 'id');
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
        return Carbon::createFromFormat('Y-m-d H:i:s', $updated_at)->format('d-m-Y à H:i:s');
        //return $updated_at->toDateString().' à '.$updated_at->toTimeString();
    }
    public function getFreeCurrencyAttribute(){
        return $free_currency = "test";
    }
}
