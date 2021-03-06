<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Topic;
use Illuminate\Support\Facades\Auth;

class TopicPolicy extends Policy
{
    public function update(User $user, Topic $topic)
    {
        if(Auth::check() && Auth::user()->can('manage_contents')){
            return true;
        } else {
            return $user->isAuthorOf($topic);
        }
    }

    public function destroy(User $user, Topic $topic)
    {
        return $user->isAuthorOf($topic);
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

    public function delete(User $user, Topic $topic)
    {
        if(Auth::check() && Auth::user()->can('manage_contents')){
            return true;
        } else {
            return $user->isAuthorOf($topic);
        }
    }
}
