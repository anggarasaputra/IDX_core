<?php

use App\Http\Library\TraitOrderRoomsPermission;
use App\Models\Admin;
use App\Models\Order\OrderRooms;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class OrderRoomsSeeder extends Seeder
{
    use TraitOrderRoomsPermission;

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
        $roleSuperAdmin = Role::updateOrCreate(
            ['name' => 'superadmin', 'guard_name' => 'admin'],
            ['name' => 'superadmin', 'guard_name' => 'admin']
        );

        for ($j = 0; $j < count($this->permissions); $j++) {
            $permission = Permission::updateOrCreate(
                ['name' => $this->permissions[$j], 'group_name' => OrderRooms::PERMISSION_GROUP_NAME],
                ['name' => $this->permissions[$j], 'group_name' => OrderRooms::PERMISSION_GROUP_NAME, 'guard_name' => 'admin']
            );

            $roleSuperAdmin->givePermissionTo($permission);
            $permission->assignRole($roleSuperAdmin);
        }

        // Assign super admin role permission to superadmin user
        $admin = Admin::where('username', 'superadmin')->first();
        if ($admin) {
            $admin->assignRole($roleSuperAdmin);
        }
    }
}
