<?php

namespace App\Policies;

use App\Models\User;
use App\Models\File;

class FilePolicy
{

    /**
     * Determine whether the user can delete the file.
     */
    public function delete(User $user, File $file): bool
    {
        // only the owner or an admin can delete a file
        $isOwner = $user->uid === $file->user_id;
        $isAdmin = $user->adminLevel > 0;
        return $isOwner || $isAdmin;
    }
}
