<?php

namespace App\Policies;

use App\Ldap\User;
use App\Models\File;
use Illuminate\Auth\Access\Response;

class FilePolicy
{

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, File $file): bool
    {
        $isOwner = $user->uid === $file->user_id;
        $isAdmin = $user->adminLevel > 0;
        return $isOwner || $isAdmin;
    }
}
