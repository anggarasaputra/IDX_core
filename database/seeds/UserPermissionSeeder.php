<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

/**
 * Class UserPermissionSeeder.
 *
 * @package App\Database\Seeds
 */
class UserPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Permission List as array
        $permissions = [
            [
                'group_name' => 'profile',
                'permissions' => [
                    // profile Permissions
                    'profile.view',
                    'profile.edit',
                ]
            ],
            [
                'group_name' => 'dashboard user',
                'permissions' => [
                    'dashboard_user.view',
                ]
            ],
            [
                'group_name' => 'user rooms',
                'permissions' => [
                    'user_rooms.view',
                ]
            ],
            [
                'group_name' => 'user gallery',
                'permissions' => [
                    'user_gallery.view',
                ]
            ],
        ];

        // Do same for the admin guard for tutorial purposes
        $roleUser = Role::updateOrCreate(
            ['name' => 'user', 'guard_name' => 'admin'],
            ['name' => 'user', 'guard_name' => 'admin']
        );

        // Create and Assign Permissions
        for ($i = 0; $i < count($permissions); $i++) {
            $permissionGroup = $permissions[$i]['group_name'];
            for ($j = 0; $j < count($permissions[$i]['permissions']); $j++) {
                // Create Permission
                $permission = Permission::updateOrCreate(
                    ['name' => $permissions[$i]['permissions'][$j], 'group_name' => $permissionGroup],
                    ['name' => $permissions[$i]['permissions'][$j], 'group_name' => $permissionGroup, 'guard_name' => 'admin']
                );
                $roleUser->givePermissionTo($permission);
                $permission->assignRole($roleUser);
            }
        }
    }
}
