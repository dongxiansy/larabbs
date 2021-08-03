<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

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

    public function update(User $currentUser, User $user)
    {
        if(Auth::check() && Auth::user()->can('manage_users')){
            return true;
        } else {
            return $currentUser->id === $user->id;
        }
    }

    public function viewAny(): bool
    {
        if(Auth::check() && Auth::user()->can('manage_users')){
            return true;
        } else {
            return false;
        }
    }

    public function view(): bool
    {
        if(Auth::check() && Auth::user()->can('manage_users')){
            return true;
        } else {
            return false;
        }
    }

    public function create(): bool
    {
        if(Auth::check() && Auth::user()->can('manage_users')){
            return true;
        } else {
            return false;
        }
    }

    public function edit(): bool
    {
        if(Auth::check() && Auth::user()->can('manage_users')){
            return true;
        } else {
            return false;
        }
    }

    public function delete(User $currentUser,User $user)
    {
         if($currentUser->can('manage_users') && !$user->hasRole('founder')){
             return true;
         } else {
             return false;
         }
//        return Auth::user()->can('manage_users') && $user->hasRole('founder');
//        return $user->isHasPermission('manage_users') && !$user->hasRole('founder');
    }
}
