<?php

namespace App\Policies;

use App\Models\Club;
use App\Models\ClubMember;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClubMemberPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     * This is often checked in the controller route context (e.g., viewing members of a specific club).
     * We'll authorize based on the club context.
     */
    public function viewAny(User $user, Club $club): bool
    {
        return $this->isAdmin($user);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ClubMember $clubMember): bool
    {
        return $this->isAdmin($user);
    }

    /**
     * Determine whether the user can create models.
     * (Typically done via application approval, not direct creation by admin)
     */
    public function create(User $user): bool
    {
        return $this->isAdmin($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ClubMember $clubMember): bool
    {
        return $this->isAdmin($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ClubMember $clubMember): bool
    {
        return $this->isAdmin($user);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ClubMember $clubMember): bool
    {
        return $this->isAdmin($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ClubMember $clubMember): bool
    {
        return $this->isAdmin($user);
    }

    // Admins can do anything related to members
    private function isAdmin(User $user): bool
    {
        return $user->role === 'admin';
    }
}
