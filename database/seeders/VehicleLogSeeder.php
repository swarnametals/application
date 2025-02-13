<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VehicleLog;
use App\Models\FuelLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class VehicleLogSeeder extends Seeder {
    public function run() {
        $vehicleIds = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20];

        // Locations with their respective distances (one-way)
        $locations = [
            'Kipushi' => 246,
            'Solwezi' => 218,
            'Kasempa' => 331,
            'Mpongwe' => 138,
            'Serenje' => 377,
            'Ndola' => 86
        ];

        $refuelLocations = ['SITE', 'KALULUSHI STATION', 'CHIMWEMWE STATION', 'SOLWEZI MERU STATION'];

        foreach ($vehicleIds as $vehicleId) {
            $lastReturnDate = Carbon::create(2025, 1, 1); // Initial reference date
            $lastEndKm = rand(60000, 200000); // Initial odometer reading

            for ($i = 0; $i < 5; $i++) {
                try {
                    // Ensure departure date is later than last return date
                    $departureDate = Carbon::parse($lastReturnDate)->addDays(rand(1, 3))->format('Y-m-d');
                    $returnDate = Carbon::parse($departureDate)->addDays(rand(1, 3))->format('Y-m-d');

                    // Select a random location and get the round-trip distance
                    $location = array_rand($locations);
                    $distanceTravelled = $locations[$location] * 2; // Round trip distance

                    $startKm = $lastEndKm; // Ensure start km matches previous end km
                    $endKm = $startKm + $distanceTravelled;

                    // Determine material delivered based on location
                    $material = ($location === 'Ndola') ? (rand(0, 1) ? 'Quarry' : 'Blocks') : 'Copper Ore';

                    $quantity = rand(20, 35);
                    $litresAdded = rand(50, 200);

                    DB::beginTransaction(); // Start transaction

                    $log = VehicleLog::create([
                        'vehicle_id' => $vehicleId,
                        'departure_date' => $departureDate,
                        'return_date' => $returnDate,
                        'start_kilometers' => $startKm,
                        'end_kilometers' => $endKm,
                        'location' => $location,
                        'material_delivered' => $material,
                        'quantity' => $quantity,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    FuelLog::create([
                        'vehicle_log_id' => $log->id,
                        'litres_added' => $litresAdded,
                        'refuel_location' => $refuelLocations[array_rand($refuelLocations)],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    DB::commit(); // Commit transaction

                    echo "✔ Log added for Vehicle ID: $vehicleId | Location: $location | Distance: {$distanceTravelled}km | Material: $material\n";

                    // Update last return date and last end km for next iteration
                    $lastReturnDate = $returnDate;
                    $lastEndKm = $endKm;

                } catch (\Exception $e) {
                    DB::rollBack(); // Rollback transaction on failure
                    echo "❌ Error inserting log for Vehicle ID: $vehicleId - " . $e->getMessage() . "\n";
                }
            }
        }
    }
}
