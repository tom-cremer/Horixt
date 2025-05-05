<?php

namespace Database\Seeders;

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {

        $roles = [
            RoleEnum::ADMIN->value => Permission::all()->pluck('name')->toArray(), // Admin gets all permissions


        ];

        foreach ($roles as $roleName => $permissions) {

            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);

            $role->syncPermissions($permissions);
        }
    }
}
