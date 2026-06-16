<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class TenantScope
{
    public static function isInternal(?User $user): bool
    {
        if (!$user) {
            return false;
        }

        return in_array($user->role, [
            'admin',
            'system_admin',
            'service_manager',
            'dispatcher',
        ]);
    }

    public static function isEngineer(?User $user): bool
    {
        return $user && $user->role === 'engineer';
    }

    public static function apply(
        Builder $query,
        ?User $user,
        string $customerColumn = 'customer_id',
        string $branchColumn = 'customer_branch_id'
    ): Builder {
        if (!$user) {
            return $query->whereRaw('1 = 0');
        }

        if (self::isInternal($user)) {
            return $query;
        }

        if (self::isEngineer($user)) {
            return $query;
        }

        if ($user->customer_id) {
            $query->where(
                $customerColumn,
                $user->customer_id
            );
        } else {
            $query->whereRaw('1 = 0');
        }

        if (
            $user->customer_access_scope === 'branch'
            &&
            $user->customer_branch_id
        ) {
            $query->where(
                $branchColumn,
                $user->customer_branch_id
            );
        }

        return $query;
    }
}
