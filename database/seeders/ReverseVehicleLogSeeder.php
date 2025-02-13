<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VehicleLog;
use App\Models\FuelLog;
use Illuminate\Support\Facades\DB;

class ReverseVehicleLogSeeder extends Seeder {
    public function run() {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // Disable foreign key checks (if necessary)

        // Delete all records in FuelLog first (to maintain FK constraints)
        FuelLog::truncate();

        // Delete all records in VehicleLog
        VehicleLog::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // Re-enable foreign key checks

        echo "✔ Successfully reversed VehicleLogSeeder!\n";
    }
}
