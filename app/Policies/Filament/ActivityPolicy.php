<?php

declare(strict_types=1);

namespace App\Policies\Filament;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;
use Spatie\Activitylog\Models\Activity;

class ActivityPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view-any:activity');
    }

    public function view(AuthUser $authUser, Activity $activity): bool
    {
        return $authUser->can('view:activity');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create:activity');
    }

    public function update(AuthUser $authUser, Activity $activity): bool
    {
        return $authUser->can('update:activity');
    }

    public function delete(AuthUser $authUser, Activity $activity): bool
    {
        return $authUser->can('delete:activity');
    }

    public function restore(AuthUser $authUser, Activity $activity): bool
    {
        return $authUser->can('restore:activity');
    }

    public function forceDelete(AuthUser $authUser, Activity $activity): bool
    {
        return $authUser->can('force-delete:activity');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force-delete-any:activity');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore-any:activity');
    }

    public function replicate(AuthUser $authUser, Activity $activity): bool
    {
        return $authUser->can('replicate:activity');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder:activity');
    }
}
