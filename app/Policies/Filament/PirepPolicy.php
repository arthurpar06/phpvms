<?php

declare(strict_types=1);

namespace App\Policies\Filament;

use App\Models\Pirep;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class PirepPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view-any:pirep');
    }

    public function view(AuthUser $authUser, Pirep $pirep): bool
    {
        return $authUser->can('view:pirep');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create:pirep');
    }

    public function update(AuthUser $authUser, Pirep $pirep): bool
    {
        return $authUser->can('update:pirep');
    }

    public function delete(AuthUser $authUser, Pirep $pirep): bool
    {
        return $authUser->can('delete:pirep');
    }

    public function restore(AuthUser $authUser, Pirep $pirep): bool
    {
        return $authUser->can('restore:pirep');
    }

    public function forceDelete(AuthUser $authUser, Pirep $pirep): bool
    {
        return $authUser->can('force-delete:pirep');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force-delete-any:pirep');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore-any:pirep');
    }

    public function replicate(AuthUser $authUser, Pirep $pirep): bool
    {
        return $authUser->can('replicate:pirep');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder:pirep');
    }
}
