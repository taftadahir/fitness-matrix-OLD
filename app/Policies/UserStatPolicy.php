<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserStat;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserStatPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, UserStat $userStat)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, UserStat $userStat)
    {
        //
    }

    public function delete(User $user, UserStat $userStat)
    {
        //
    }

    public function restore(User $user, UserStat $userStat)
    {
        //
    }

    public function forceDelete(User $user, UserStat $userStat)
    {
        //
    }
}
