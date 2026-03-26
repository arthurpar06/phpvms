<?php

declare(strict_types=1);

namespace App\Policies\Filament;

use App\Models\Fare;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class FarePolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view-any:fare');
    }

    public function view(AuthUser $authUser, Fare $fare): bool
    {
        return $authUser->can('view:fare');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create:fare');
    }

    public function update(AuthUser $authUser, Fare $fare): bool
    {
        return $authUser->can('update:fare');
    }

    public function delete(AuthUser $authUser, Fare $fare): bool
    {
        return $authUser->can('delete:fare');
    }

    public function restore(AuthUser $authUser, Fare $fare): bool
    {
        return $authUser->can('restore:fare');
    }

    public function forceDelete(AuthUser $authUser, Fare $fare): bool
    {
        return $authUser->can('force-delete:fare');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force-delete-any:fare');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore-any:fare');
    }

    public function replicate(AuthUser $authUser, Fare $fare): bool
    {
        return $authUser->can('replicate:fare');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder:fare');
    }
}
