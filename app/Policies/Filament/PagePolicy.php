<?php

declare(strict_types=1);

namespace App\Policies\Filament;

use App\Models\Page;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class PagePolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view-any:page');
    }

    public function view(AuthUser $authUser, Page $page): bool
    {
        return $authUser->can('view:page');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create:page');
    }

    public function update(AuthUser $authUser, Page $page): bool
    {
        return $authUser->can('update:page');
    }

    public function delete(AuthUser $authUser, Page $page): bool
    {
        return $authUser->can('delete:page');
    }

    public function restore(AuthUser $authUser, Page $page): bool
    {
        return $authUser->can('restore:page');
    }

    public function forceDelete(AuthUser $authUser, Page $page): bool
    {
        return $authUser->can('force-delete:page');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force-delete-any:page');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore-any:page');
    }

    public function replicate(AuthUser $authUser, Page $page): bool
    {
        return $authUser->can('replicate:page');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder:page');
    }
}
