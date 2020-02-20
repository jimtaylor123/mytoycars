<?php

namespace App\Models\Policies;

use App\Models\User;
use App\Models\Race;
use Illuminate\Auth\Access\HandlesAuthorization;

class RacePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any races.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the race.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Race  $race
     * @return mixed
     */
    public function view(User $user, Race $race)
    {
        return true;
    }

    /**
     * Determine whether the user can create races.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return (bool) $user->admin;
    }

    /**
     * Determine whether the user can update the race.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Race  $race
     * @return mixed
     */
    public function update(User $user, Race $race)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can delete the race.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Race  $race
     * @return mixed
     */
    public function delete(User $user, Race $race)
    {
        return $user->id == $race->user_id;
    }

    /**
     * Determine whether the user can restore the race.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Race  $race
     * @return mixed
     */
    public function restore(User $user, Race $race)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the race.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Race  $race
     * @return mixed
     */
    public function forceDelete(User $user, Race $race)
    {
        return false;
    }
}
