<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class LinkPolicy
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

    public function viewAny(): bool
    {
        if(Auth::check() && Auth::user()->can('manage_contents')){
            return true;
        } else {
            return false;
        }
    }

    public function create(): bool
    {
        if(Auth::check() && Auth::user()->can('manage_contents')){
            return true;
        } else {
            return false;
        }
    }

    public function view(): bool
    {
        if(Auth::check() && Auth::user()->can('manage_contents')){
            return true;
        } else {
            return false;
        }
    }

    public function update()
    {
        if(Auth::check() && Auth::user()->can('manage_contents')){
            return true;
        } else {
            return false;
        }
    }

    public function edit(): bool
    {
        if(Auth::check() && Auth::user()->can('manage_contents')){
            return true;
        } else {
            return false;
        }
    }

    public function delete(): bool
    {
        if(Auth::check() && Auth::user()->can('manage_contents')){
            return true;
        } else {
            return false;
        }
    }
}
