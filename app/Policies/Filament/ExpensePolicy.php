<?php

declare(strict_types=1);

namespace App\Policies\Filament;

use App\Models\Expense;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class ExpensePolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view-any:expense');
    }

    public function view(AuthUser $authUser, Expense $expense): bool
    {
        return $authUser->can('view:expense');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create:expense');
    }

    public function update(AuthUser $authUser, Expense $expense): bool
    {
        return $authUser->can('update:expense');
    }

    public function delete(AuthUser $authUser, Expense $expense): bool
    {
        return $authUser->can('delete:expense');
    }

    public function restore(AuthUser $authUser, Expense $expense): bool
    {
        return $authUser->can('restore:expense');
    }

    public function forceDelete(AuthUser $authUser, Expense $expense): bool
    {
        return $authUser->can('force-delete:expense');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force-delete-any:expense');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore-any:expense');
    }

    public function replicate(AuthUser $authUser, Expense $expense): bool
    {
        return $authUser->can('replicate:expense');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder:expense');
    }
}
