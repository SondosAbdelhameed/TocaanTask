<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Auth\Access\Response;

class UserAddressPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, UserAddress $address): Response
    {
        return $user->id === $address->user_id ? Response::allow() : Response::deny('You do not own this address.') ;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, UserAddress $address): Response
    {
        return $user->id === $address->user_id ? Response::allow() : Response::deny('You do not own this address.') ;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, UserAddress $address): Response
    {
        return $user->id === $address->user_id ? Response::allow() : Response::deny('You do not own this address.') ;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, UserAddress $address): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, UserAddress $address): bool
    {
        return false;
    }
}
