<?php

declare(strict_types=1);

namespace App\Policies\Filament;

use App\Models\Aircraft;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class AircraftPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view-any:aircraft');
    }

    public function view(AuthUser $authUser, Aircraft $aircraft): bool
    {
        return $authUser->can('view:aircraft');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create:aircraft');
    }

    public function update(AuthUser $authUser, Aircraft $aircraft): bool
    {
        return $authUser->can('update:aircraft');
    }

    public function delete(AuthUser $authUser, Aircraft $aircraft): bool
    {
        return $authUser->can('delete:aircraft');
    }

    public function restore(AuthUser $authUser, Aircraft $aircraft): bool
    {
        return $authUser->can('restore:aircraft');
    }

    public function forceDelete(AuthUser $authUser, Aircraft $aircraft): bool
    {
        return $authUser->can('force-delete:aircraft');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force-delete-any:aircraft');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore-any:aircraft');
    }

    public function replicate(AuthUser $authUser, Aircraft $aircraft): bool
    {
        return $authUser->can('replicate:aircraft');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder:aircraft');
    }
}
