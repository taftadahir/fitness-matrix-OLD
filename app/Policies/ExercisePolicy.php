<?php

namespace App\Policies;

use App\Models\Exercise;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExercisePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Exercise $exercise)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, Exercise $exercise)
    {
        //
    }

    public function delete(User $user, Exercise $exercise)
    {
        //
    }

    public function restore(User $user, Exercise $exercise)
    {
        //
    }

    public function forceDelete(User $user, Exercise $exercise)
    {
        //
    }
}
