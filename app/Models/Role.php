<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use \Spatie\Permission\Models\Role as SpatieRole;
use App\Models\CreditPrice;
use App\Models\Currency;

class Role extends SpatieRole
{
    use HasFactory;

    /* protected $fillable = [
        'name','guard_name','events_price','date_credit','free_events','free_annoncements','events_price','annoucements_price','date_credit'
    ]; */
    protected $guarded = [];

    public function currency()
    {
        return $this->belongsTo(Currency::class,'currency_id','id');
    }

    public function credit_prices()
    {
        return $this->hasMany(CreditPrice::class);
    }

    /**
     * User can pay to subscribe to a role.
     * We the need to set a polymorph relation with the payments model
     */
    public function payments()
    {
        return $this->morphMany(\App\Model\Payment::class, 'purchassable');
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

    public function getUsersCountAttribute()
    {
        return User::role($this->name)->count();
    }
}
