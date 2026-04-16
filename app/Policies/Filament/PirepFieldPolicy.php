<?php

declare(strict_types=1);

namespace App\Policies\Filament;

use App\Models\PirepField;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class PirepFieldPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view-any:pirep-field');
    }

    public function view(AuthUser $authUser, PirepField $pirepField): bool
    {
        return $authUser->can('view:pirep-field');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create:pirep-field');
    }

    public function update(AuthUser $authUser, PirepField $pirepField): bool
    {
        return $authUser->can('update:pirep-field');
    }

    public function delete(AuthUser $authUser, PirepField $pirepField): bool
    {
        return $authUser->can('delete:pirep-field');
    }

    public function restore(AuthUser $authUser, PirepField $pirepField): bool
    {
        return $authUser->can('restore:pirep-field');
    }

    public function forceDelete(AuthUser $authUser, PirepField $pirepField): bool
    {
        return $authUser->can('force-delete:pirep-field');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force-delete-any:pirep-field');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore-any:pirep-field');
    }

    public function replicate(AuthUser $authUser, PirepField $pirepField): bool
    {
        return $authUser->can('replicate:pirep-field');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder:pirep-field');
    }
}
