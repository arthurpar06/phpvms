<?php

declare(strict_types=1);

namespace App\Policies\Filament;

use App\Models\SimBriefAirframe;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class SimBriefAirframePolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view-any:sim-brief-airframe');
    }

    public function view(AuthUser $authUser, SimBriefAirframe $simBriefAirframe): bool
    {
        return $authUser->can('view:sim-brief-airframe');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create:sim-brief-airframe');
    }

    public function update(AuthUser $authUser, SimBriefAirframe $simBriefAirframe): bool
    {
        return $authUser->can('update:sim-brief-airframe');
    }

    public function delete(AuthUser $authUser, SimBriefAirframe $simBriefAirframe): bool
    {
        return $authUser->can('delete:sim-brief-airframe');
    }

    public function restore(AuthUser $authUser, SimBriefAirframe $simBriefAirframe): bool
    {
        return $authUser->can('restore:sim-brief-airframe');
    }

    public function forceDelete(AuthUser $authUser, SimBriefAirframe $simBriefAirframe): bool
    {
        return $authUser->can('force-delete:sim-brief-airframe');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force-delete-any:sim-brief-airframe');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore-any:sim-brief-airframe');
    }

    public function replicate(AuthUser $authUser, SimBriefAirframe $simBriefAirframe): bool
    {
        return $authUser->can('replicate:sim-brief-airframe');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder:sim-brief-airframe');
    }
}
