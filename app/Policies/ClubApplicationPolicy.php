<?php

namespace App\Policies;

use App\Models\ClubApplication;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClubApplicationPolicy
{
    use HandlesAuthorization;

    // Allow admins to bypass all checks
    public function before(User $user, string $ability): bool|null
    {
        if ($user->role === 'admin') {
            return true;
        }
        return null; // Continue to other checks
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Admins bypass via before(). Users can view the list (filtered by controller).
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ClubApplication $clubApplication): bool
    {
        // Admins bypass. Users can view their own application.
        return $user->id === $clubApplication->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Any authenticated user can attempt to create an application.
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ClubApplication $clubApplication): bool
    {
        // Only admins (handled by before()) can approve/reject.
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ClubApplication $clubApplication): bool
    {
        // Only admins (handled by before()) can delete.
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ClubApplication $clubApplication): bool
    {
        return false; // Not implemented
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ClubApplication $clubApplication): bool
    {
        return false; // Not implemented
    }
}
