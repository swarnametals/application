<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Validation\ValidationException;

class EquipmentController extends Controller {

    public function index() {
        try {
            $equipments = Equipment::with('trips')->latest()->paginate(10);
            return view('equipments.index', compact('equipments'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to fetch equipment.');
        }
    }

    //future update search functionality
    // public function index(Request $request) {
    //     try {
    //         $query = Equipment::query();

    //         $search = $request->input('search');

    //         if ($search) {
    //             $query->where('registration_number', 'LIKE', "%{$search}%")
    //                 ->orWhere('equipment_name', 'LIKE', "%{$search}%")
    //                 ->orWhere('asset_code', 'LIKE', "%{$search}%");
    //         }

    //         $equipments = $query->orderBy('created_at', 'desc')->get();

    //         return view('equipments.index', compact('equipments', 'search'));
    //     } catch (Exception $e) {
    //         return redirect()->back()->with('error', 'Failed to fetch equipment.');
    //     }
    // }

    public function create() {
        try {
            return view('equipments.create');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function store(Request $request) {
        try {
            $request->validate([
                'asset_code' => 'nullable|string|max:255|unique:equipments,asset_code',
                'registration_number' => 'nullable|string|max:255|unique:equipments,registration_number',
                'chasis_number' => 'nullable|string|max:255|unique:equipments,chasis_number',
                'engine_number' => 'nullable|string|max:255|unique:equipments,engine_number',
                'type' => 'required|in:HMV,LMV,Machinery',
                'ownership' => 'required|string|max:255',
                'equipment_name' => 'required|string|max:255',
                'date_purchased' => 'required|date',
                'value' => 'required|numeric|min:0',
                'pictures.*' => 'nullable|image|max:2048', // Validate each uploaded image (max 2MB)
            ]);

            // Handle file uploads
            $pictures = [];
            if ($request->hasFile('pictures')) {
                foreach ($request->file('pictures') as $file) {
                    if ($file->isValid()) {
                        $path = $file->store('equipment_pictures', 'public');
                        $pictures[] = $path;
                    }
                }
            }

            $equipment = Equipment::create([
                'asset_code' => $request->asset_code,
                'registration_number' => $request->registration_number,
                'chasis_number' => $request->chasis_number,
                'engine_number' => $request->engine_number,
                'type' => $request->type,
                'ownership' => $request->ownership,
                'equipment_name' => $request->equipment_name,
                'date_purchased' => $request->date_purchased,
                'value' => $request->value,
                'pictures' => json_encode($pictures), // Store file paths as JSON
            ]);

            return redirect()->route('equipments.index')->with('success', 'Equipment ' . ($equipment->registration_number ?? $equipment->asset_code ) . ' added successfully.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            \Log::error('Error storing equipment: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to add equipment: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Equipment $equipment) {
        try {
            $equipment->load(['trips.fuels', 'trips.driver']);
            $trips = $equipment->trips()->with('driver')->latest()->paginate(10);
            return view('equipments.show', compact('equipment', 'trips'));
        } catch (\Exception $e) {
            \Log::error('Error showing equipment: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while fetching equipment details.');
        }
    }

    public function edit(Equipment $equipment) {
        try {
            return view('equipments.edit', compact('equipment'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function update(Request $request, Equipment $equipment) {
        try {
            $request->validate([
                'asset_code' => 'nullable|string|max:255|unique:equipments,asset_code,' . $equipment->id,
                'registration_number' => 'nullable|string|max:255|unique:equipments,registration_number,' . $equipment->id,
                'chasis_number' => 'nullable|string|max:255|unique:equipments,chasis_number,' . $equipment->id,
                'engine_number' => 'nullable|string|max:255|unique:equipments,engine_number,' . $equipment->id,
                'type' => 'required|in:HMV,LMV,Machinery',
                'ownership' => 'required|string|max:255',
                'equipment_name' => 'required|string|max:255',
                'date_purchased' => 'required|date',
                'value' => 'required|numeric|min:0',
                'pictures.*' => 'nullable|image|max:2048', // Validate each uploaded image
            ]);

            // Handle file uploads while preserving existing pictures
            $pictures = $equipment->pictures ? json_decode($equipment->pictures, true) : [];
            if ($request->hasFile('pictures')) {
                foreach ($request->file('pictures') as $file) {
                    if ($file->isValid()) {
                        $path = $file->store('equipment_pictures', 'public');
                        $pictures[] = $path;
                    }
                }
            }

            $equipment->update([
                'asset_code' => $request->asset_code,
                'registration_number' => $request->registration_number,
                'chasis_number' => $request->chasis_number,
                'engine_number' => $request->engine_number,
                'type' => $request->type,
                'ownership' => $request->ownership,
                'equipment_name' => $request->equipment_name,
                'date_purchased' => $request->date_purchased,
                'value' => $request->value,
                'pictures' => json_encode($pictures), // Update with new picture paths
            ]);

            return redirect()->route('equipments.index')->with('success', 'Equipment ' . ($equipment->registration_number ?? $equipment->asset_code ?? 'unknown') . ' updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            \Log::error('Error updating equipment: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update equipment: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Equipment $equipment) {
        try {
            // $equipment->delete();
            // return redirect()->route('equipment.index')->with('success', 'Equipment deleted successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete equipment.');
        }
    }

    // -------------------Trip Methods----------------
    public function storeTrip(Request $request) {
        try {
            $tripValidated = $request->validate([
                'equipment_id' => 'required|exists:equipments,id',
                'driver_id' => 'required|exists:employees,id',
                'departure_date' => 'required|date',
                'return_date' => 'nullable|date|after_or_equal:departure_date',
                'start_kilometers' => 'required|integer|min:0',
                'end_kilometers' => 'nullable|integer|gte:start_kilometers',
                'location' => 'required|string|max:255',
                'material_delivered' => 'nullable|string|max:255',
                'quantity' => 'nullable|numeric|min:0',
                'fuels' => 'required|array|min:1', // At least one fuel entry
                'fuels.*.litres_added' => 'required|numeric|min:0',
                'fuels.*.refuel_location' => 'nullable|string|max:255',
            ]);

            // Generate unique trip number in format YYYYMMDD-RRRR e.g., 20250226-7756
            $datePrefix = now()->format('Ymd');
            do {
                $randomNumber = rand(1000, 9999);
                $tripNumber = "$datePrefix-$randomNumber";
            } while (Trip::where('trip_number', $tripNumber)->exists());

            $tripValidated['trip_number'] = $tripNumber;

            DB::transaction(function () use ($tripValidated) {
                $trip = Trip::create(Arr::except($tripValidated, ['fuels']));

                foreach ($tripValidated['fuels'] as $fuelData) {
                    $trip->fuels()->create([
                        'trip_id' => $trip->id,
                        'machinery_usage_id' => null, // Explicitly set to null for vehicle trips
                        'litres_added' => $fuelData['litres_added'],
                        'refuel_location' => $fuelData['refuel_location'],
                    ]);
                }
            });

            return redirect()->route('equipments.show', $tripValidated['equipment_id'])->with('success', 'Trip and fuel records added successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            \Log::error('Error storing trip and fuels: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to add trip and fuel records please try again');
        }
    }

    public function editTrip(Trip $trip) {
        try {
            $trip->load('fuels');

            $response = [
                'equipment_id' => $trip->equipment_id,
                'driver_id' => $trip->driver_id,
                'trip_number' => $trip->trip_number, // Optional, not used in form but included for completeness
                'departure_date' => $trip->departure_date->toDateString(), // Format as YYYY-MM-DD
                'return_date' => $trip->return_date ? $trip->return_date->toDateString() : null,
                'start_kilometers' => $trip->start_kilometers,
                'end_kilometers' => $trip->end_kilometers,
                'location' => $trip->location,
                'material_delivered' => $trip->material_delivered,
                'quantity' => $trip->quantity,
                'fuels' => $trip->fuels->map(function ($fuel) {
                    return [
                        'id' => $fuel->id,
                        'litres_added' => $fuel->litres_added,
                        'refuel_location' => $fuel->refuel_location,
                    ];
                })->toArray(),
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            \Log::error('Error fetching trip for edit: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch trip data'], 500);
        }
    }

    public function updateTrip(Request $request, Trip $trip) {
        try {
            $tripValidated = $request->validate([
                'equipment_id' => 'required|exists:equipments,id',
                'driver_id' => 'required|exists:employees,id',
                'departure_date' => 'required|date',
                'return_date' => 'nullable|date|after_or_equal:departure_date',
                'start_kilometers' => 'required|integer|min:0',
                'end_kilometers' => 'nullable|integer|gte:start_kilometers',
                'location' => 'required|string|max:255',
                'material_delivered' => 'nullable|string|max:255',
                'quantity' => 'nullable|numeric|min:0',
                'fuels' => 'required|array|min:1', // At least one fuel entry
                'fuels.*.id' => 'nullable|exists:fuels,id', // For existing fuel records
                'fuels.*.litres_added' => 'required|numeric|min:0',
                'fuels.*.refuel_location' => 'nullable|string|max:255',
            ]);

            // Use a transaction to update trip and fuels together
            DB::transaction(function () use ($trip, $tripValidated) {
                // Update the trip (trip_number remains unchanged)
                $trip->update(Arr::except($tripValidated, ['fuels']));

                // Sync fuel entries: update existing, create new, delete removed
                $existingFuelIds = $trip->fuels->pluck('id')->toArray();
                $submittedFuelIds = array_filter(array_column($tripValidated['fuels'], 'id'));

                // Delete fuels not in the submitted list
                $trip->fuels()->whereNotIn('id', $submittedFuelIds)->delete();

                // Update or create fuel entries
                foreach ($tripValidated['fuels'] as $fuelData) {
                    if (isset($fuelData['id']) && in_array($fuelData['id'], $existingFuelIds)) {
                        // Update existing fuel
                        $trip->fuels()->where('id', $fuelData['id'])->update([
                            'litres_added' => $fuelData['litres_added'],
                            'refuel_location' => $fuelData['refuel_location'],
                        ]);
                    } else {
                        // Create new fuel
                        $trip->fuels()->create([
                            'trip_id' => $trip->id,
                            'machinery_usage_id' => null,
                            'litres_added' => $fuelData['litres_added'],
                            'refuel_location' => $fuelData['refuel_location'],
                        ]);
                    }
                }
            });

            return response()->json(['success' => true, 'message' => 'Trip and fuel records updated successfully.']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->validator->errors()], 422);
        } catch (\Exception $e) {
            \Log::error('Error updating trip and fuels: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update trip and fuel records: ' . $e->getMessage()], 500);
        }
    }

    public function getLastTripEndKilometers($equipmentId) {
        try {
            $lastTrip = Trip::where('equipment_id', $equipmentId)
                ->orderBy('return_date', 'desc')
                ->orderBy('id', 'desc') 
                ->first();

            $response = [
                'start_kilometers' => $lastTrip ? $lastTrip->start_kilometers : 0,
                'end_kilometers' => $lastTrip ? $lastTrip->end_kilometers : null,
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            \Log::error('Error fetching last trip end kilometers: ' . $e->getMessage());
            return response()->json([
                'start_kilometers' => 0,
                'end_kilometers' => null,
                'error' => 'Failed to fetch last trip details',
            ], 500);
        }
    }
}
