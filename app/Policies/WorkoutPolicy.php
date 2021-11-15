<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Workout;
use Illuminate\Auth\Access\HandlesAuthorization;

class WorkoutPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Workout $workout)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, Workout $workout)
    {
        //
    }

    public function delete(User $user, Workout $workout)
    {
        //
    }

    public function restore(User $user, Workout $workout)
    {
        //
    }

    public function forceDelete(User $user, Workout $workout)
    {
        //
    }
}
