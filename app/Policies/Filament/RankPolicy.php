<?php

declare(strict_types=1);

namespace App\Policies\Filament;

use App\Models\Rank;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class RankPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view-any:rank');
    }

    public function view(AuthUser $authUser, Rank $rank): bool
    {
        return $authUser->can('view:rank');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create:rank');
    }

    public function update(AuthUser $authUser, Rank $rank): bool
    {
        return $authUser->can('update:rank');
    }

    public function delete(AuthUser $authUser, Rank $rank): bool
    {
        return $authUser->can('delete:rank');
    }

    public function restore(AuthUser $authUser, Rank $rank): bool
    {
        return $authUser->can('restore:rank');
    }

    public function forceDelete(AuthUser $authUser, Rank $rank): bool
    {
        return $authUser->can('force-delete:rank');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force-delete-any:rank');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore-any:rank');
    }

    public function replicate(AuthUser $authUser, Rank $rank): bool
    {
        return $authUser->can('replicate:rank');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder:rank');
    }
}
