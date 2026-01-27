<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $authenticatedUser, User $targetUser): bool
    {
        if ($authenticatedUser->id === $targetUser->id) {
            return true;
        }

        // 2. Ish beruvchi faqat unga ariza topshirgan nomzodni ko'ra oladi
        if ($authenticatedUser->role === 'employer') {
            return $authenticatedUser->companies()
                ->whereHas('jobs.applications', function ($query) use ($targetUser) {
                    $query->where('user_id', $targetUser->id);
                })->exists();
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $authenticatedUser, User $targetUser): bool
    {
        return $authenticatedUser->id === $targetUser->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}
