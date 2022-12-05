<?php

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class OrderGallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Assign Permission Rooms
         */

        $permissions = [
            [
                'group_name' => 'order gallery',
                'permissions' => [
                    'order_gallery.index',
                    'order_gallery.approve',
                    'order_gallery.reject',
                ]
            ],
        ];

        // Do same for the admin guard for tutorial purposes
        $roleSuperAdmin = Role::updateOrCreate(
            ['name' => 'superadmin', 'guard_name' => 'admin'],
            ['name' => 'superadmin', 'guard_name' => 'admin']
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
                $roleSuperAdmin->givePermissionTo($permission);
                $permission->assignRole($roleSuperAdmin);
            }
        }

        // Assign super admin role permission to superadmin user
        $admin = Admin::where('username', 'superadmin')->first();
        if ($admin) {
            $admin->assignRole($roleSuperAdmin);
        }
    }
}
