<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\VehicleLog;
use App\Models\FuelLog;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Exception;

class VehicleLogController extends Controller {
    public function index() {
        try {
            $logs = VehicleLog::with('vehicle')->get();
            return view('vehicle_logs.index', compact('logs'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to load vehicle logs.');
        }
    }

    public function getLastTripEndKilometers($vehicleId) {
        try {
            // Fetch the last trip for the selected vehicle
            $lastTrip = VehicleLog::where('vehicle_id', $vehicleId)
                ->orderBy('departure_date', 'desc')
                ->first();

            // Return the last trip's end_kilometers or 0 if no trips exist
            return response()->json([
                'end_kilometers' => $lastTrip ? $lastTrip->end_kilometers : 0
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch last trip details.'
            ], 500);
        }
    }

    public function create(Vehicle $vehicle) {
        try {
            if (!$vehicle) {
                return redirect()->route('vehicle_logs.index')->with('error', 'Vehicle not found.');
            }

            // Fetch the last trip's end kilometers
            $lastTrip = VehicleLog::where('vehicle_id', $vehicle->id)
                ->orderBy('departure_date', 'desc')
                ->first();

            $lastEndKilometers = $lastTrip ? $lastTrip->end_kilometers : 0;

            return view('vehicle_logs.create', compact('vehicle', 'lastEndKilometers'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to load the create log form.');
        }
    }

    public function store(Request $request) {
        try {
            $request->validate([
                'vehicle_id' => 'required|exists:vehicles,id',
                'departure_date' => 'required|date',
                'return_date' => 'nullable|date',
                'start_kilometers' => 'required|integer',
                'end_kilometers' => 'nullable|integer|gte:start_kilometers',
                'material_delivered' => 'nullable|string',
                'location' => 'required|string',
                'quantity' => 'nullable|numeric',
                'litres_added' => 'required|numeric|min:0',
                'refuel_location' => 'nullable|string',
            ]);

            $vehicleLog = VehicleLog::create($request->only([
                'vehicle_id', 'departure_date','return_date', 'start_kilometers', 'end_kilometers',
                'material_delivered', 'location', 'quantity'
            ]));

            FuelLog::create([
                'vehicle_log_id' => $vehicleLog->id,
                'litres_added' => $request->litres_added,
                'refuel_location' => $request->refuel_location,
            ]);

            return redirect()->route('vehicles.index', $request->input('vehicle_id'))
                ->with('success', 'Trip and fuel information added successfully. For '. $vehicleLog->vehicle->registration_number);
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to add vehicle log. Please try again.');
        }
    }

    public function show(VehicleLog $vehicleLog) {
        try {
            return view('vehicle_logs.show', compact('vehicleLog'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to load vehicle log details.');
        }
    }

    public function edit($id) {
        $trip = VehicleLog::find($id);
        if (!$trip) {
            return response()->json(['error' => 'Trip not found'], 404);
        }
        return response()->json($trip);
    }

    // public function edit(VehicleLog $vehicleLog) {
    //     try {
    //         return view('vehicle_logs.edit', compact('vehicleLog'));
    //     } catch (Exception $e) {
    //         return redirect()->back()->with('error', 'Failed to load vehicle log edit form.');
    //     }
    // }

    // public function update(Request $request, VehicleLog $vehicleLog) {
    //     try {
    //         $request->validate([
    //             'vehicle_id' => 'required|exists:vehicles,id',
    //             'departure_date' => 'required|date',
    //             'return_date' => 'nullable|date',
    //             'start_kilometers' => 'required|integer',
    //             'end_kilometers' => 'nullable|integer|gte:start_kilometers',
    //             'material_delivered' => 'nullable|string',
    //             'location' => 'required|string',
    //             'quantity' => 'nullable|numeric',
    //             'litres_added' => 'nullable|numeric|min:0',
    //             'refuel_location' => 'nullable|string',
    //         ]);

    //         $vehicleLog->update($request->only([
    //             'vehicle_id', 'departure_date', 'return_date', 'start_kilometers', 'end_kilometers',
    //             'material_delivered', 'location', 'quantity'
    //         ]));

    //         // later update
    //         // If fuel log details are provided, create a new fuel log
    //         // if ($request->filled('litres_added')) {
    //         //     FuelLog::create([
    //         //         'vehicle_log_id' => $vehicleLog->id,
    //         //         'litres_added' => $request->litres_added,
    //         //         'refuel_location' => $request->refuel_location,
    //         //     ]);
    //         // }

    //         return redirect()->route('vehicles.show', $request->input('vehicle_id'))
    //             ->with('success', 'Trip information updated successfully.');
    //     } catch (ValidationException $e) {
    //         return redirect()->back()->withErrors($e->errors())->withInput();
    //     } catch (Exception $e) {
    //         return redirect()->back()->with('error', 'Failed to update vehicle Trip.');
    //     }
    // }

    public function update(Request $request, VehicleLog $vehicleLog) {
        try {
            // Validate request
            $request->validate([
                'vehicle_id' => 'required|exists:vehicles,id',
                'departure_date' => 'required|date',
                'return_date' => 'nullable|date',
                'start_kilometers' => 'required|integer',
                'end_kilometers' => 'nullable|integer|gte:start_kilometers',
                'material_delivered' => 'nullable|string',
                'location' => 'required|string',
                'quantity' => 'nullable|numeric',
                'litres_added' => 'nullable|numeric|min:0',
                'refuel_location' => 'nullable|string',
            ]);

            // Update the Vehicle Log
            $vehicleLog->update($request->only([
                'vehicle_id', 'departure_date', 'return_date', 'start_kilometers', 'end_kilometers',
                'material_delivered', 'location', 'quantity'
            ]));

            return response()->json([
                'success' => true,
                'message' => 'Trip information updated successfully.',
                'vehicle_log' => $vehicleLog
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update vehicle trip.'
            ], 500);
        }
    }

    public function destroy(VehicleLog $vehicleLog) {
        try {
            $vehicleLog->delete();
            return redirect()->route('vehicle_logs.index')->with('success', 'Vehicle log deleted successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete vehicle log.');
        }
    }
}

