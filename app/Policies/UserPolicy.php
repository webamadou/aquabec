<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    /**
     * 
     * user update policy
     * A user can be updated by the super-admin or the admin or by the one whom the profile belongs to
     */
    public function update(User $user)
    {
        $current_user = auth()->user();
        if($current_user->hasRole('super-admin') || $current_user->hasRole('admin')){
            return true;
        } elseif($user->id === $current_user->id) {
            return true;
        }else{
            return false;
        }
    }
}
