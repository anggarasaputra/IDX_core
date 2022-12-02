<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(RolePermissionSeeder::class);
        $this->call(UserPermissionSeeder::class);
        $this->call(MasterFloorSeeder::class);
        $this->call(RoomsSeeder::class);
        $this->call(OrderRoomsSeeder::class);
        $this->call(OrderGallerySeeder::class);
    }
}
