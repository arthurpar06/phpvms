<?php

declare(strict_types=1);

namespace App\Policies\Filament;

use App\Models\Award;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class AwardPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view-any:award');
    }

    public function view(AuthUser $authUser, Award $award): bool
    {
        return $authUser->can('view:award');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create:award');
    }

    public function update(AuthUser $authUser, Award $award): bool
    {
        return $authUser->can('update:award');
    }

    public function delete(AuthUser $authUser, Award $award): bool
    {
        return $authUser->can('delete:award');
    }

    public function restore(AuthUser $authUser, Award $award): bool
    {
        return $authUser->can('restore:award');
    }

    public function forceDelete(AuthUser $authUser, Award $award): bool
    {
        return $authUser->can('force-delete:award');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force-delete-any:award');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore-any:award');
    }

    public function replicate(AuthUser $authUser, Award $award): bool
    {
        return $authUser->can('replicate:award');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder:award');
    }
}
