<?php

namespace App\Policies;

use App\Models\LegalQuestion;
use App\Models\User;

class LegalQuestionPolicy
{
    /**
     * Determine if the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isLawyer();
    }

    /**
     * Determine if the user can view the model.
     */
    public function view(User $user, LegalQuestion $legalQuestion): bool
    {
        if ($user->isAdmin()) {
            return true;
        }
        
        if ($user->isLawyer()) {
            return $legalQuestion->assigned_lawyer_id === $user->id;
        }
        
        return $legalQuestion->user_id === $user->id;
    }

    /**
     * Determine if the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isCustomer() || $user->isAdmin();
    }

    /**
     * Determine if the user can update the model.
     */
    public function update(User $user, LegalQuestion $legalQuestion): bool
    {
        if ($user->isAdmin()) {
            return true;
        }
        
        if ($user->isLawyer()) {
            return $legalQuestion->assigned_lawyer_id === $user->id;
        }
        
        return $legalQuestion->user_id === $user->id;
    }

    /**
     * Determine if the user can delete the model.
     */
    public function delete(User $user, LegalQuestion $legalQuestion): bool
    {
        return $user->isAdmin();
    }
}

