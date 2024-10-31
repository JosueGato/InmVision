<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Propertyprice;
use Illuminate\Auth\Access\HandlesAuthorization;

class PropertypricePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_propertyprice');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Propertyprice $propertyprice): bool
    {
        return $user->can('view_propertyprice');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_propertyprice');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Propertyprice $propertyprice): bool
    {
        return $user->can('update_propertyprice');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Propertyprice $propertyprice): bool
    {
        return $user->can('delete_propertyprice');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_propertyprice');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, Propertyprice $propertyprice): bool
    {
        return $user->can('force_delete_propertyprice');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_propertyprice');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, Propertyprice $propertyprice): bool
    {
        return $user->can('restore_propertyprice');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_propertyprice');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, Propertyprice $propertyprice): bool
    {
        return $user->can('replicate_propertyprice');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_propertyprice');
    }
}
