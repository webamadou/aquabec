<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    use HasFactory;

    protected $guarded = [];
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
     * 
     */
    public function getRefAttribute()
    {
        return self::formatCredit($this->attributes["ref"]);
        return $returned_ref;
    }
    public function getTotalFreeCreditsAttribute()
    {
        return self::formatCredit(Credit::where("credit_type", 0)->sum("value"));
    }
    public function getTotalPaidCreditsAttribute()
    {
        return self::formatCredit(Credit::where("credit_type", 1)->sum("value"));
    }

    /**
     * Format given value to put a space after each three caracters starting from the end
     */
    public static function formatCredit($value)
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

    public function updateBankerCredit()
    {
        //We need to get the banker profil
        $user   = User::whereHas("roles", function($q){$q->where("name", "Banker");})->first();

        $total  = Credit::where('credit_type', 0)->sum('value');
        $user->free_credits = $total;
        $total  = Credit::where('credit_type', 1)->sum('value');
        $user->paid_credits = $total;
        $user->save();
    }
}