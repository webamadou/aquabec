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
     * Format ref attribite to put a space after each two caracters
     * 
     * 
     */
    public function getRefAttribute()
    {
        $returned_ref = '';
        $ref = str_split($this->attributes["ref"]);
        $i = 0;
        for ($c = count($ref) - 1; $c >= 0 ; $c--) {
            $returned_ref = ($i % 3) === 0 ? @$ref[$c]." ".$returned_ref : @$ref[$c].$returned_ref;
            $i++;
        }
        return $returned_ref;
    }
}
