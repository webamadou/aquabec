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
     * Perform pre-authorization checks.
     *
     * @param  \App\Models\User  $user
     * @param  string  $ability
     * @return void|bool
     */
    public function before(User $user, $ability)
    {
        if ($user->hasRole('super-admin') || $user->hasRole('admin')) {
            return true;
        }
    }
    /**
     * 
     * user update policy
     * A user can be updated by the super-admin or the admin or by the one whom the profile belongs to
     */
    /* public function update(User $user, \App\Models\City $current_user)
    {
        // $current_user = auth()->user();
        /* if($current_user->hasRole('super-admin') || $current_user->hasRole('admin')){
            return true;
        } else *
        if($user->id === $current_user->id) {
            return true;
        } elseif($user->godfather === $current_user->id){
            return true;
        }

        return false;
    } */
    /**
     * A profile can
     */
    public function chefVendor(User $user)
    {
        $current_user = auth()->user();
        return $user->hasRole('chef-vendeur');
    }
    public function vendor(User $user)
    {
        return ($user->hasRole('chef-vendeur') || $user->hasRole('vendeur'));
    }
}
