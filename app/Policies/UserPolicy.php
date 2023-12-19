<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        $isOwner = $user->uid == $model->uid;
        $isAdmin = $user->adminLevel > 0;
        return $isOwner || $isAdmin;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function edit(User $user, User $model): bool
    {
        $isOwner = $user->uid == $model->uid;
        $isAdmin = $user->adminLevel > 0;
        return $isOwner || $isAdmin;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        $isOwner = $user->uid == $model->uid;
        $isAdmin = $user->adminLevel > 0;
        return $isOwner || $isAdmin;
    }

    // determine whether the user can promote another user to admin
    public function promote(User $user, User $model): bool
    {
        $isAdmin = $user->adminLevel > 1;
        return $isAdmin;
    }

    // determine whether the user can demote another user to admin
    public function demote(User $user, User $model): bool
    {
        $isAdmin = $user->adminLevel > 1;
        return $isAdmin;
    }
}
