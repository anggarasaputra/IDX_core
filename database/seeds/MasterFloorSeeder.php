<?php

use App\Http\Library\TraitFloorPermission;
use App\Models\Admin;
use App\Models\Master\Floor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class MasterFloorSeeder extends Seeder
{
    use TraitFloorPermission;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!(Schema::hasTable(Floor::TABLE_NAME))) {
            return;
        }

        for ($i = 1; $i <= Floor::MAX_FLOOR; $i++) {
            try {
                Floor::updateOrCreate(
                    ['id' => $i],
                    ['name' => "Lantai {$i}"]
                );
            } catch (\Throwable $th) {
                report($th);
            }
        }

        /**
         * Assign Permission Floor
         */
        $roleSuperAdmin = Role::updateOrCreate(
            ['name' => 'superadmin', 'guard_name' => 'admin'],
            ['name' => 'superadmin', 'guard_name' => 'admin']
        );

        for ($j = 0; $j < count($this->permissions); $j++) {
            $permission = Permission::updateOrCreate(
                ['name' => $this->permissions[$j], 'group_name' => Floor::PERMISSION_GROUP_NAME],
                ['name' => $this->permissions[$j], 'group_name' => Floor::PERMISSION_GROUP_NAME, 'guard_name' => 'admin']
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
