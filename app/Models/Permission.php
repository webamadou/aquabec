<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use \Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use HasFactory;

    protected $fillable = [
                          'name','guard_name','permission_group'
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
        return User::permission($this->name)->count();
    }
}
