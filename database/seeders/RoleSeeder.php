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
            RoleEnum::MEMBER ->value => [
                PermissionEnum::FILES_VIEW->value,
                PermissionEnum::FILES_UPLOAD->value,
                PermissionEnum::FILES_RENAME->value,
                PermissionEnum::FILES_DOWNLOAD->value,
                PermissionEnum::FILES_SHARE->value,
                PermissionEnum::FILES_DELETE->value,
                PermissionEnum::FILES_MOVE->value,
                PermissionEnum::FILES_LOCK->value,
                PermissionEnum::FILES_UNLOCK->value,
                PermissionEnum::TODOS_VIEW->value,
                PermissionEnum::TODOS_CREATE->value,
                PermissionEnum::TODOS_UPDATE->value,
                PermissionEnum::TODOS_DELETE->value,
                PermissionEnum::TODOS_ASSIGN->value,
                PermissionEnum::TODOS_COMMENT->value,
                PermissionEnum::TRACKS_VIEW->value,
                PermissionEnum::TRACKS_CREATE->value,
                PermissionEnum::TRACKS_UPDATE->value,
                PermissionEnum::TRACKS_DELETE->value,
                PermissionEnum::PROJECT_VIEW->value,
                PermissionEnum::PROJECT_CREATE->value,
            ],

            RoleEnum::INTERN->value => [
                PermissionEnum::FILES_VIEW->value,
                PermissionEnum::FILES_UPLOAD->value,
                PermissionEnum::FILES_RENAME->value,
                PermissionEnum::FILES_DOWNLOAD->value,
                PermissionEnum::FILES_MOVE->value,
                PermissionEnum::TODOS_VIEW->value,
                PermissionEnum::TODOS_CREATE->value,
                PermissionEnum::TODOS_UPDATE->value,
                PermissionEnum::TODOS_DELETE->value,
                PermissionEnum::TODOS_ASSIGN->value,
                PermissionEnum::TRACKS_VIEW->value,
                PermissionEnum::TRACKS_CREATE->value,
                PermissionEnum::TRACKS_UPDATE->value,
                PermissionEnum::TRACKS_DELETE->value,
                PermissionEnum::PROJECT_VIEW->value,
                PermissionEnum::PROJECT_CREATE->value,
            ],

            RoleEnum::GUEST->value => [
                PermissionEnum::FILES_VIEW->value,
                PermissionEnum::TODOS_VIEW->value,
                PermissionEnum::TRACKS_VIEW->value,
                PermissionEnum::PROJECT_VIEW->value,
            ],
        ];

        foreach ($roles as $roleName => $permissions) {

            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);

            $role->syncPermissions($permissions);
        }
    }
}
