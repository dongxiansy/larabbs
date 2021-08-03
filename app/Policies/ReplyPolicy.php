<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reply;
use Illuminate\Support\Facades\Auth;

class ReplyPolicy extends Policy
{
    public function update(User $user, Reply $reply)
    {
        if(Auth::check() && Auth::user()->can('manage_contents')){
            return true;
        } else {
            return $user->isAuthorOf($reply) || $user->isAuthorOf($reply->topic);
        }
    }

    public function destroy(User $user, Reply $reply)
    {
        return $user->isAuthorOf($reply) || $user->isAuthorOf($reply->topic);
    }

    public function viewAny(): bool
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

    public function create(): bool
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

    public function delete(User $user, Reply $reply)
    {
        if(Auth::check() && Auth::user()->can('manage_contents')){
            return true;
        } else {
            return $user->isAuthorOf($reply) || $user->isAuthorOf($reply->topic);
        }
    }
}
