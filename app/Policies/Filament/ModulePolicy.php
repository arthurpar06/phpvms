<?php

declare(strict_types=1);

namespace App\Policies\Filament;

use App\Models\Module;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class ModulePolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view-any:module');
    }

    public function view(AuthUser $authUser, Module $module): bool
    {
        return $authUser->can('view:module');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create:module');
    }

    public function update(AuthUser $authUser, Module $module): bool
    {
        return $authUser->can('update:module');
    }

    public function delete(AuthUser $authUser, Module $module): bool
    {
        return $authUser->can('delete:module');
    }

    public function restore(AuthUser $authUser, Module $module): bool
    {
        return $authUser->can('restore:module');
    }

    public function forceDelete(AuthUser $authUser, Module $module): bool
    {
        return $authUser->can('force-delete:module');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force-delete-any:module');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore-any:module');
    }

    public function replicate(AuthUser $authUser, Module $module): bool
    {
        return $authUser->can('replicate:module');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder:module');
    }
}
