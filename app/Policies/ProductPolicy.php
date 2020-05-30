<?php

namespace App\Policies;

use App\OrderQueue;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any order queues.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the order queue.
     *
     * @param  \App\User  $user
     * @param  \App\OrderQueue  $orderQueue
     * @return mixed
     */
    public function view(User $user, OrderQueue $orderQueue)
    {
        //
    }

    /**
     * Determine whether the user can create order queues.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return in_array($user->email, User::all()->toArray());
    }

    /**
     * Determine whether the user can update the order queue.
     *
     * @param  \App\User  $user
     * @param  \App\OrderQueue  $orderQueue
     * @return mixed
     */
    public function update(User $user, OrderQueue $orderQueue)
    {
        //
    }

    /**
     * Determine whether the user can delete the order queue.
     *
     * @param  \App\User  $user
     * @param  \App\OrderQueue  $orderQueue
     * @return mixed
     */
    public function delete(User $user, OrderQueue $orderQueue)
    {
        //
    }

    /**
     * Determine whether the user can restore the order queue.
     *
     * @param  \App\User  $user
     * @param  \App\OrderQueue  $orderQueue
     * @return mixed
     */
    public function restore(User $user, OrderQueue $orderQueue)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the order queue.
     *
     * @param  \App\User  $user
     * @param  \App\OrderQueue  $orderQueue
     * @return mixed
     */
    public function forceDelete(User $user, OrderQueue $orderQueue)
    {
        //
    }
}
