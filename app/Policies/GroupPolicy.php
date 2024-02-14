<?php

namespace App\Policies;

use App\Models\Group;
use App\Models\User;

class GroupPolicy
{
    /**
     * Determine whether the user can view the model.
     *
     * @param User $user The user attempting to access the group.
     * @param Group $group The group being considered.
     * @return bool True if the user can view the group, false otherwise.
     */
    public function view(User $user, Group $group): bool
    {
        // Super admins can always view
        if ($user->hasRole('super-admin')) {
            return true;
        }

        // Check if the user is a member of the group
        return $user->groups()
            ->where('GROUPS.id', $group->id) // Use GROUP alias for clarity
            ->exists();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user The user attempting to delete the voucher code.
     * @param Group $group The group being considered.
     * @return bool True if the user can delete the group, false otherwise.
     */
    public function delete(User $user, Group $group): bool
    {
        // Super admins can always view
        if ($user->hasRole('super-admin')) {
            return true;
        }

        // Check if the user is a member of the group
        return $user->groups()
            ->where('GROUPS.id', $group->id) // Use GROUP alias for clarity
            ->exists();
    }
}
