<?php

use App\Models\Master\Lantai;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class MasterLantaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!(Schema::hasTable(Lantai::TABLE_NAME))) {
            return;
        }

        for ($i = 1; $i <= Lantai::MAX_FLOOR; $i++) {
            try {
                Lantai::updateOrCreate(
                    ['id' => $i],
                    ['name' => "Lantai {$i}"]
                );
            } catch (\Throwable $th) {
                report($th);
            }
        }
    }
}
