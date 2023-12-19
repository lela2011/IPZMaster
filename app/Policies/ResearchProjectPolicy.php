<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ResearchProject;

class ResearchProjectPolicy
{

    /**
     * Determine whether the user can update the model.
     */
    public function edit(User $user, ResearchProject $researchProject): bool
    {
        $isAdmin = $user->adminLevel > 0;
        $isLeader = $researchProject->leaders->contains($user);
        return $isAdmin || $isLeader;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ResearchProject $researchProject): bool
    {
        $isAdmin = $user->adminLevel > 0;
        $isLeader = $researchProject->leaders->contains($user);
        return $isAdmin || $isLeader;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ResearchProject $researchProject): bool
    {
        $isAdmin = $user->adminLevel > 0;
        $isLeader = $researchProject->leaders->contains($user);
        return $isAdmin || $isLeader;
    }
}
