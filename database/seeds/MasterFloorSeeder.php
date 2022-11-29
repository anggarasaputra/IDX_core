<?php

use App\Models\Master\Floor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class MasterFloorSeeder extends Seeder
{
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
    }
}
