<?php

declare(strict_types=1);

namespace App\Policies\Filament;

use App\Models\Flight;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class FlightPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view-any:flight');
    }

    public function view(AuthUser $authUser, Flight $flight): bool
    {
        return $authUser->can('view:flight');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create:flight');
    }

    public function update(AuthUser $authUser, Flight $flight): bool
    {
        return $authUser->can('update:flight');
    }

    public function delete(AuthUser $authUser, Flight $flight): bool
    {
        return $authUser->can('delete:flight');
    }

    public function restore(AuthUser $authUser, Flight $flight): bool
    {
        return $authUser->can('restore:flight');
    }

    public function forceDelete(AuthUser $authUser, Flight $flight): bool
    {
        return $authUser->can('force-delete:flight');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force-delete-any:flight');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore-any:flight');
    }

    public function replicate(AuthUser $authUser, Flight $flight): bool
    {
        return $authUser->can('replicate:flight');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder:flight');
    }
}
