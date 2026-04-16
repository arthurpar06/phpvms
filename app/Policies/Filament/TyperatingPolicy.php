<?php

declare(strict_types=1);

namespace App\Policies\Filament;

use App\Models\Typerating;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class TyperatingPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view-any:typerating');
    }

    public function view(AuthUser $authUser, Typerating $typerating): bool
    {
        return $authUser->can('view:typerating');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create:typerating');
    }

    public function update(AuthUser $authUser, Typerating $typerating): bool
    {
        return $authUser->can('update:typerating');
    }

    public function delete(AuthUser $authUser, Typerating $typerating): bool
    {
        return $authUser->can('delete:typerating');
    }

    public function restore(AuthUser $authUser, Typerating $typerating): bool
    {
        return $authUser->can('restore:typerating');
    }

    public function forceDelete(AuthUser $authUser, Typerating $typerating): bool
    {
        return $authUser->can('force-delete:typerating');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force-delete-any:typerating');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore-any:typerating');
    }

    public function replicate(AuthUser $authUser, Typerating $typerating): bool
    {
        return $authUser->can('replicate:typerating');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder:typerating');
    }
}
