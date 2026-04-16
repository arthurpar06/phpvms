<?php

declare(strict_types=1);

namespace App\Policies\Filament;

use App\Models\UserField;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class UserFieldPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view-any:user-field');
    }

    public function view(AuthUser $authUser, UserField $userField): bool
    {
        return $authUser->can('view:user-field');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create:user-field');
    }

    public function update(AuthUser $authUser, UserField $userField): bool
    {
        return $authUser->can('update:user-field');
    }

    public function delete(AuthUser $authUser, UserField $userField): bool
    {
        return $authUser->can('delete:user-field');
    }

    public function restore(AuthUser $authUser, UserField $userField): bool
    {
        return $authUser->can('restore:user-field');
    }

    public function forceDelete(AuthUser $authUser, UserField $userField): bool
    {
        return $authUser->can('force-delete:user-field');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force-delete-any:user-field');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore-any:user-field');
    }

    public function replicate(AuthUser $authUser, UserField $userField): bool
    {
        return $authUser->can('replicate:user-field');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder:user-field');
    }
}
