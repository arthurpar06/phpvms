<?php

declare(strict_types=1);

namespace App\Policies\Filament;

use App\Models\Subfleet;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class SubfleetPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view-any:subfleet');
    }

    public function view(AuthUser $authUser, Subfleet $subfleet): bool
    {
        return $authUser->can('view:subfleet');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create:subfleet');
    }

    public function update(AuthUser $authUser, Subfleet $subfleet): bool
    {
        return $authUser->can('update:subfleet');
    }

    public function delete(AuthUser $authUser, Subfleet $subfleet): bool
    {
        return $authUser->can('delete:subfleet');
    }

    public function restore(AuthUser $authUser, Subfleet $subfleet): bool
    {
        return $authUser->can('restore:subfleet');
    }

    public function forceDelete(AuthUser $authUser, Subfleet $subfleet): bool
    {
        return $authUser->can('force-delete:subfleet');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force-delete-any:subfleet');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore-any:subfleet');
    }

    public function replicate(AuthUser $authUser, Subfleet $subfleet): bool
    {
        return $authUser->can('replicate:subfleet');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder:subfleet');
    }
}
