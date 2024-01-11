<?php

namespace App\Policies;

use App\Models\ResearchArea;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ResearchAreaPolicy
{

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ResearchArea $researchArea): bool
    {
        $managerUid = $researchArea->manager_uid;
        $userID = $user->uid;
        $isManager = $userID === $managerUid;
        $isAdmin = $user->admin_level > 0;
        return $isManager || $isAdmin;
    }

    /**
     * Determine whether the user can edit the model.
     */
    public function edit(User $user, ResearchArea $researchArea): bool
    {
        $managerUid = $researchArea->manager_uid;
        $userID = $user->uid;
        $isManager = $userID === $managerUid;
        $isAdmin = $user->admin_level > 0;
        return $isManager || $isAdmin;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ResearchArea $researchArea): bool
    {
        $managerUid = $researchArea->manager_uid;
        $userID = $user->uid;
        $isManager = $userID === $managerUid;
        $isAdmin = $user->admin_level > 0;
        return $isManager || $isAdmin;
    }
}
