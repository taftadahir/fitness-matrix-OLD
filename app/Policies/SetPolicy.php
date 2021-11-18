<?php

namespace App\Policies;

use App\Models\Set;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SetPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Set $set)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, Set $set)
    {
        //
    }

    public function delete(User $user, Set $set)
    {
        //
    }

    public function restore(User $user, Set $set)
    {
        //
    }

    public function forceDelete(User $user, Set $set)
    {
        //
    }
}
