<?php

declare(strict_types=1);

namespace App\Policies\Filament;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view-any:role');
    }

    public function view(AuthUser $authUser, Role $role): bool
    {
        return $authUser->can('view:role');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create:role');
    }

    public function update(AuthUser $authUser, Role $role): bool
    {
        return $authUser->can('update:role');
    }

    public function delete(AuthUser $authUser, Role $role): bool
    {
        return $authUser->can('delete:role');
    }

    public function restore(AuthUser $authUser, Role $role): bool
    {
        return $authUser->can('restore:role');
    }

    public function forceDelete(AuthUser $authUser, Role $role): bool
    {
        return $authUser->can('force-delete:role');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force-delete-any:role');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore-any:role');
    }

    public function replicate(AuthUser $authUser, Role $role): bool
    {
        return $authUser->can('replicate:role');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder:role');
    }
}
