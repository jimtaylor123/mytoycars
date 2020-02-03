<?php

namespace App\Models\Policies;

use App\Models\User;
use App\Models\Car;
use Illuminate\Auth\Access\HandlesAuthorization;

class CarPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any cars.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the car.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Car  $car
     * @return mixed
     */
    public function view(User $user, Car $car)
    {
        return $user->id == $car->user_id;
    }

    /**
     * Determine whether the user can create cars.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the car.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Car  $car
     * @return mixed
     */
    public function update(User $user, Car $car)
    {
        return $user->id == $car->user_id;
    }

    /**
     * Determine whether the user can delete the car.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Car  $car
     * @return mixed
     */
    public function delete(User $user, Car $car)
    {
        return $user->id == $car->user_id;
    }

    /**
     * Determine whether the user can restore the car.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Car  $car
     * @return mixed
     */
    public function restore(User $user, Car $car)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the car.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Car  $car
     * @return mixed
     */
    public function forceDelete(User $user, Car $car)
    {
        return false;
    }
}
