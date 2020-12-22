<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use \Spatie\Permission\Models\Role as SpatieRole;
use App\Models\CreditPrice;

class Role extends SpatieRole
{
    use HasFactory;

    /* protected $fillable = [
        'name','guard_name','events_price','date_credit','free_events','free_annoncements','events_price','annoucements_price','date_credit'
    ]; */
    protected $guarded = [];


    public function credit_prices()
    {
        return $this->hasMany(CreditPrice::class);
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
