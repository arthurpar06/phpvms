<?php

namespace Database\Seeders;

use BezhanSalleh\FilamentShield\Support\Utils;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\PermissionRegistrar;

class ShieldSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $tenants = '[]';
        $users = '[]';
        $userTenantPivot = '[]';
        $rolesWithPermissions = '[{"name":"super_admin","guard_name":"web","permissions":["view-any:airline","view:airline","create:airline","update:airline","delete:airline","restore:airline","force-delete:airline","force-delete-any:airline","restore-any:airline","replicate:airline","reorder:airline","view-any:airport","view:airport","create:airport","update:airport","delete:airport","restore:airport","force-delete:airport","force-delete-any:airport","restore-any:airport","replicate:airport","reorder:airport","view-any:award","view:award","create:award","update:award","delete:award","restore:award","force-delete:award","force-delete-any:award","restore-any:award","replicate:award","reorder:award","view-any:expense","view:expense","create:expense","update:expense","delete:expense","restore:expense","force-delete:expense","force-delete-any:expense","restore-any:expense","replicate:expense","reorder:expense","view-any:fare","view:fare","create:fare","update:fare","delete:fare","restore:fare","force-delete:fare","force-delete-any:fare","restore-any:fare","replicate:fare","reorder:fare","view-any:flight","view:flight","create:flight","update:flight","delete:flight","restore:flight","force-delete:flight","force-delete-any:flight","restore-any:flight","replicate:flight","reorder:flight","view-any:invite","view:invite","create:invite","update:invite","delete:invite","restore:invite","force-delete:invite","force-delete-any:invite","restore-any:invite","replicate:invite","reorder:invite","view-any:module","view:module","create:module","update:module","delete:module","restore:module","force-delete:module","force-delete-any:module","restore-any:module","replicate:module","reorder:module","view-any:page","view:page","create:page","update:page","delete:page","restore:page","force-delete:page","force-delete-any:page","restore-any:page","replicate:page","reorder:page","view-any:pirep-field","view:pirep-field","create:pirep-field","update:pirep-field","delete:pirep-field","restore:pirep-field","force-delete:pirep-field","force-delete-any:pirep-field","restore-any:pirep-field","replicate:pirep-field","reorder:pirep-field","view-any:pirep","view:pirep","create:pirep","update:pirep","delete:pirep","restore:pirep","force-delete:pirep","force-delete-any:pirep","restore-any:pirep","replicate:pirep","reorder:pirep","view-any:rank","view:rank","create:rank","update:rank","delete:rank","restore:rank","force-delete:rank","force-delete-any:rank","restore-any:rank","replicate:rank","reorder:rank","view-any:sim-brief-airframe","view:sim-brief-airframe","create:sim-brief-airframe","update:sim-brief-airframe","delete:sim-brief-airframe","restore:sim-brief-airframe","force-delete:sim-brief-airframe","force-delete-any:sim-brief-airframe","restore-any:sim-brief-airframe","replicate:sim-brief-airframe","reorder:sim-brief-airframe","view-any:aircraft","view:aircraft","create:aircraft","update:aircraft","delete:aircraft","restore:aircraft","force-delete:aircraft","force-delete-any:aircraft","restore-any:aircraft","replicate:aircraft","reorder:aircraft","view-any:subfleet","view:subfleet","create:subfleet","update:subfleet","delete:subfleet","restore:subfleet","force-delete:subfleet","force-delete-any:subfleet","restore-any:subfleet","replicate:subfleet","reorder:subfleet","view-any:typerating","view:typerating","create:typerating","update:typerating","delete:typerating","restore:typerating","force-delete:typerating","force-delete-any:typerating","restore-any:typerating","replicate:typerating","reorder:typerating","view-any:user-field","view:user-field","create:user-field","update:user-field","delete:user-field","restore:user-field","force-delete:user-field","force-delete-any:user-field","restore-any:user-field","replicate:user-field","reorder:user-field","view-any:user","view:user","create:user","update:user","delete:user","restore:user","force-delete:user","force-delete-any:user","restore-any:user","replicate:user","reorder:user","view-any:role","view:role","create:role","update:role","delete:role","restore:role","force-delete:role","force-delete-any:role","restore-any:role","replicate:role","reorder:role","view-any:activity","view:activity","create:activity","update:activity","delete:activity","restore:activity","force-delete:activity","force-delete-any:activity","restore-any:activity","replicate:activity","reorder:activity","view:backups","view:dashboard","view:finances","view:maintenance","view:settings","view:installer","view:updater","view:airline-finance-chart","view:airline-finance-table","view:version-widget"]}]';
        $directPermissions = '[]';

        // 1. Seed tenants first (if present)
        if (!blank($tenants) && $tenants !== '[]') {
            static::seedTenants($tenants);
        }

        // 2. Seed roles with permissions
        static::makeRolesWithPermissions($rolesWithPermissions);

        // 3. Seed direct permissions
        static::makeDirectPermissions($directPermissions);

        // 4. Seed users with their roles/permissions (if present)
        if (!blank($users) && $users !== '[]') {
            static::seedUsers($users);
        }

        // 5. Seed user-tenant pivot (if present)
        if (!blank($userTenantPivot) && $userTenantPivot !== '[]') {
            static::seedUserTenantPivot($userTenantPivot);
        }

        $this->command->info('Shield Seeding Completed.');
    }

    protected static function seedTenants(string $tenants): void
    {
        if (blank($tenantData = json_decode($tenants, true))) {
            return;
        }

        $tenantModel = '';
        if (blank($tenantModel)) {
            return;
        }

        foreach ($tenantData as $tenant) {
            $tenantModel::firstOrCreate(
                ['id' => $tenant['id']],
                $tenant
            );
        }
    }

    protected static function seedUsers(string $users): void
    {
        if (blank($userData = json_decode($users, true))) {
            return;
        }

        $userModel = 'App\Models\User';
        $tenancyEnabled = false;

        foreach ($userData as $data) {
            // Extract role/permission data before creating user
            $roles = $data['roles'] ?? [];
            $permissions = $data['permissions'] ?? [];
            $tenantRoles = $data['tenant_roles'] ?? [];
            $tenantPermissions = $data['tenant_permissions'] ?? [];
            unset($data['roles'], $data['permissions'], $data['tenant_roles'], $data['tenant_permissions']);

            $user = $userModel::firstOrCreate(
                ['email' => $data['email']],
                $data
            );

            // Handle tenancy mode - sync roles/permissions per tenant
            if ($tenancyEnabled && (!empty($tenantRoles) || !empty($tenantPermissions))) {
                foreach ($tenantRoles as $tenantId => $roleNames) {
                    $contextId = $tenantId === '_global' ? null : $tenantId;
                    setPermissionsTeamId($contextId);
                    $user->syncRoles($roleNames);
                }

                foreach ($tenantPermissions as $tenantId => $permissionNames) {
                    $contextId = $tenantId === '_global' ? null : $tenantId;
                    setPermissionsTeamId($contextId);
                    $user->syncPermissions($permissionNames);
                }
            } else {
                // Non-tenancy mode
                if (!empty($roles)) {
                    $user->syncRoles($roles);
                }

                if (!empty($permissions)) {
                    $user->syncPermissions($permissions);
                }
            }
        }
    }

    protected static function seedUserTenantPivot(string $pivot): void
    {
        if (blank($pivotData = json_decode($pivot, true))) {
            return;
        }

        $pivotTable = '';
        if (blank($pivotTable)) {
            return;
        }

        foreach ($pivotData as $row) {
            $uniqueKeys = [];

            if (isset($row['user_id'])) {
                $uniqueKeys['user_id'] = $row['user_id'];
            }

            $tenantForeignKey = 'team_id';
            if (!blank($tenantForeignKey) && isset($row[$tenantForeignKey])) {
                $uniqueKeys[$tenantForeignKey] = $row[$tenantForeignKey];
            }

            if ($uniqueKeys !== []) {
                DB::table($pivotTable)->updateOrInsert($uniqueKeys, $row);
            }
        }
    }

    protected static function makeRolesWithPermissions(string $rolesWithPermissions): void
    {
        if (blank($rolePlusPermissions = json_decode($rolesWithPermissions, true))) {
            return;
        }

        /** @var Model $roleModel */
        $roleModel = Utils::getRoleModel();
        /** @var Model $permissionModel */
        $permissionModel = Utils::getPermissionModel();

        $tenancyEnabled = false;
        $teamForeignKey = 'team_id';

        foreach ($rolePlusPermissions as $rolePlusPermission) {
            $tenantId = $rolePlusPermission[$teamForeignKey] ?? null;

            // Set tenant context for role creation and permission sync
            if ($tenancyEnabled) {
                setPermissionsTeamId($tenantId);
            }

            $roleData = [
                'name'       => $rolePlusPermission['name'],
                'guard_name' => $rolePlusPermission['guard_name'],
            ];

            // Include tenant ID in role data (can be null for global roles)
            if ($tenancyEnabled && !blank($teamForeignKey)) {
                $roleData[$teamForeignKey] = $tenantId;
            }

            $role = $roleModel::firstOrCreate($roleData);

            if (!blank($rolePlusPermission['permissions'])) {
                $permissionModels = collect($rolePlusPermission['permissions'])
                    ->map(fn ($permission) => $permissionModel::firstOrCreate([
                        'name'       => $permission,
                        'guard_name' => $rolePlusPermission['guard_name'],
                    ]))
                    ->all();

                $role->syncPermissions($permissionModels);
            }
        }
    }

    public static function makeDirectPermissions(string $directPermissions): void
    {
        if (blank($permissions = json_decode($directPermissions, true))) {
            return;
        }

        /** @var Model $permissionModel */
        $permissionModel = Utils::getPermissionModel();

        foreach ($permissions as $permission) {
            if ($permissionModel::whereName($permission['name'])->doesntExist()) {
                $permissionModel::create([
                    'name'       => $permission['name'],
                    'guard_name' => $permission['guard_name'],
                ]);
            }
        }
    }
}
