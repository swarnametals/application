<?php

namespace App\Http\Controllers;

use App\Models\FuelLog;
use App\Models\VehicleLog;
use Illuminate\Http\Request;

class FuelLogController extends Controller {
    public function index() {
        $fuelLogs = FuelLog::with('vehicleLog.vehicle')->get();
        return view('fuel_logs.index', compact('fuelLogs'));
    }

    public function create() {
        $vehicleLogs = VehicleLog::with('vehicle')->get();
        return view('fuel_logs.create', compact('vehicleLogs'));
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'vehicle_log_id' => 'required|exists:vehicle_logs,id',
    //         'litres_added' => 'required|numeric|min:0',
    //         'refuel_location' => 'nullable|string',
    //     ]);

    //     FuelLog::create($request->all());

    //     return redirect()->route('fuel_logs.index')->with('success', 'Fuel log added successfully.');
    // }

    public function store(Request $request) {
        $request->validate([
            'vehicle_log_id' => 'required|exists:vehicle_logs,id',
            'litres_added' => 'required|numeric|min:0',
            'refuel_location' => 'nullable|string',
        ]);

        $fuelLog = FuelLog::create([
            'vehicle_log_id' => $request->vehicle_log_id,
            'litres_added' => $request->litres_added,
            'refuel_location' => $request->refuel_location,
        ]);

        return response()->json([
            'success' => true,
            'litres_added' => $fuelLog->litres_added,
            'refuel_location' => $fuelLog->refuel_location,
        ]);
    }

    public function show(FuelLog $fuelLog)
    {
        return view('fuel_logs.show', compact('fuelLog'));
    }

    public function edit(FuelLog $fuelLog)
    {
        $vehicleLogs = VehicleLog::with('vehicle')->get();
        return view('fuel_logs.edit', compact('fuelLog', 'vehicleLogs'));
    }

    public function update(Request $request, FuelLog $fuelLog)
    {
        $request->validate([
            'vehicle_log_id' => 'required|exists:vehicle_logs,id',
            'litres_added' => 'required|numeric|min:0',
            'refuel_location' => 'nullable|string',
        ]);

        $fuelLog->update($request->all());

        return redirect()->route('fuel_logs.index')->with('success', 'Fuel log updated successfully.');
    }

    public function destroy(FuelLog $fuelLog)
    {
        $fuelLog->delete();
        return redirect()->route('fuel_logs.index')->with('success', 'Fuel log deleted successfully.');
    }
}
