<?php

declare(strict_types=1);

namespace App\Policies\Filament;

use App\Models\Airport;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class AirportPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view-any:airport');
    }

    public function view(AuthUser $authUser, Airport $airport): bool
    {
        return $authUser->can('view:airport');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create:airport');
    }

    public function update(AuthUser $authUser, Airport $airport): bool
    {
        return $authUser->can('update:airport');
    }

    public function delete(AuthUser $authUser, Airport $airport): bool
    {
        return $authUser->can('delete:airport');
    }

    public function restore(AuthUser $authUser, Airport $airport): bool
    {
        return $authUser->can('restore:airport');
    }

    public function forceDelete(AuthUser $authUser, Airport $airport): bool
    {
        return $authUser->can('force-delete:airport');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force-delete-any:airport');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore-any:airport');
    }

    public function replicate(AuthUser $authUser, Airport $airport): bool
    {
        return $authUser->can('replicate:airport');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder:airport');
    }
}
