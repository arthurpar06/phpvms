<?php

declare(strict_types=1);

namespace App\Policies\Filament;

use App\Models\Invite;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class InvitePolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view-any:invite');
    }

    public function view(AuthUser $authUser, Invite $invite): bool
    {
        return $authUser->can('view:invite');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create:invite');
    }

    public function update(AuthUser $authUser, Invite $invite): bool
    {
        return $authUser->can('update:invite');
    }

    public function delete(AuthUser $authUser, Invite $invite): bool
    {
        return $authUser->can('delete:invite');
    }

    public function restore(AuthUser $authUser, Invite $invite): bool
    {
        return $authUser->can('restore:invite');
    }

    public function forceDelete(AuthUser $authUser, Invite $invite): bool
    {
        return $authUser->can('force-delete:invite');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force-delete-any:invite');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore-any:invite');
    }

    public function replicate(AuthUser $authUser, Invite $invite): bool
    {
        return $authUser->can('replicate:invite');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder:invite');
    }
}
