<?php

declare(strict_types=1);

namespace App\Policies\Filament;

use App\Models\Airline;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class AirlinePolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view-any:airline');
    }

    public function view(AuthUser $authUser, Airline $airline): bool
    {
        return $authUser->can('view:airline');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create:airline');
    }

    public function update(AuthUser $authUser, Airline $airline): bool
    {
        return $authUser->can('update:airline');
    }

    public function delete(AuthUser $authUser, Airline $airline): bool
    {
        return $authUser->can('delete:airline');
    }

    public function restore(AuthUser $authUser, Airline $airline): bool
    {
        return $authUser->can('restore:airline');
    }

    public function forceDelete(AuthUser $authUser, Airline $airline): bool
    {
        return $authUser->can('force-delete:airline');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force-delete-any:airline');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore-any:airline');
    }

    public function replicate(AuthUser $authUser, Airline $airline): bool
    {
        return $authUser->can('replicate:airline');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder:airline');
    }
}
