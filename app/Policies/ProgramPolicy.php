<?php

namespace App\Policies;

use App\Models\Program;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProgramPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Program $program)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, Program $program)
    {
        //
    }

    public function delete(User $user, Program $program)
    {
        //
    }

    public function restore(User $user, Program $program)
    {
        //
    }

    public function forceDelete(User $user, Program $program)
    {
        //
    }
}
