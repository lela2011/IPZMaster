<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ResearchProject;
use Illuminate\Support\Facades\Log;

class ResearchProjectPolicy
{

    /**
     * Determine whether the user can update the model.
     */
    public function edit(User $user, ResearchProject $researchProject): bool
    {
        return $researchProject->leaders->contains($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ResearchProject $researchProject): bool
    {
        return $researchProject->leaders->contains($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ResearchProject $researchProject): bool
    {
        return $researchProject->leaders->contains($user);
    }
}
