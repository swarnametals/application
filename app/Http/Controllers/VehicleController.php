<?php
namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Exception;
use PDF;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Carbon\Carbon;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;


class VehicleController extends Controller {

    public function index(Request $request) {
        try {
            $query = Vehicle::query();

            $search = $request->input('search');

            if ($search) {
                $query->where('registration_number', 'LIKE', "%{$search}%")
                    ->orWhere('vehicle_type', 'LIKE', "%{$search}%")
                    ->orWhere('driver', 'LIKE', "%{$search}%");
            }

            // Eager load latest vehicle log
            $vehicles = $query->with('latestVehicleLog')->orderBy('created_at', 'desc')->get();

            return view('vehicles.index', compact('vehicles', 'search'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to fetch vehicles.');
        }
    }

    public function create() {
        try {
            return view('vehicles.create');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function store(Request $request) {
        try {
            $request->validate([
                'registration_number' => 'required|unique:vehicles,registration_number',
                'vehicle_type' => 'required|string',
                'other_vehicle_type' => 'nullable|string',
                'driver' => 'nullable|string',
            ]);

            // Check if the user selected "Other" and use the provided input
            $vehicleType = $request->vehicle_type === 'Other' ? $request->other_vehicle_type : $request->vehicle_type;

            Vehicle::create([
                'registration_number' => $request->registration_number,
                'vehicle_type' => $vehicleType,
                'driver' => $request->driver,
            ]);

            return redirect()->route('vehicles.index')->with('success', 'Vehicle added successfully.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to add vehicle. Please try again.');
        }
    }

    public function show(Vehicle $vehicle, Request $request) {
        try {
            $month = $request->query('month');
            $year = $request->query('year');

            $query = $vehicle->vehicleLogs()->with('fuelLogs')->orderBy('departure_date', 'desc');

            if ($month) {
                $query->whereMonth('departure_date', $month);
            }

            if ($year) {
                $query->whereYear('departure_date', $year);
            }

            $vehicleLogs = $query->paginate(10);

            return view('vehicles.show', compact('vehicle', 'vehicleLogs'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('vehicles.index')->with('error', 'Vehicle not found.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while fetching vehicle details. Please try again later.');
        }
    }

    public function edit(Vehicle $vehicle) {
        try {
            return view('vehicles.edit', compact('vehicle'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function update(Request $request, Vehicle $vehicle) {
        try {
            $request->validate([
                'registration_number' => 'required|unique:vehicles,registration_number,' . $vehicle->id,
                'vehicle_type' => 'required',
                'other_vehicle_type' => 'nullable|string|max:255',
            ]);

            $vehicleData = $request->all();
            if ($request->vehicle_type === 'Other') {
                $vehicleData['vehicle_type'] = $request->other_vehicle_type;
            }

            $vehicle->update($vehicleData);

            return redirect()->route('vehicles.index')->with('success', 'Vehicle information updated successfully.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to update vehicle. Please try again.');
        }
    }

    public function destroy(Vehicle $vehicle) {
        try {
            // $vehicle->delete();
            // return redirect()->route('vehicles.index')->with('success', 'Vehicle deleted successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete vehicle.');
        }
    }


    // -------------------Vehicle Report Generation Methods -------------------------------
    public function reportType(Vehicle $vehicle) {
        return view('reports.index', compact('vehicle'));
    }

    public function generateAll(Request $request) {
        $request->validate([
            'month' => 'required|numeric|min:1|max:12',
            'year' => 'required|numeric|min:2000|max:' . date('Y'),
            'format' => 'required|in:csv,pdf'
        ]);

        try {
            $month = $request->month;
            $year = $request->year;
            $format = $request->format;

            $vehicles = Vehicle::orderBy('registration_number', 'asc')->get();

            $reportData = [];

            foreach ($vehicles as $vehicle) {
                $logs = $vehicle->vehicleLogs()
                    ->whereMonth('departure_date', $month)
                    ->whereYear('departure_date', $year)
                    ->get();

                $totalFuelUsed = $logs->sum(function ($log) {
                    return $log->fuelLogs->sum('litres_added');
                });

                $totalDistanceTravelled = $logs->sum('distance_travelled');
                $totalMaterialDelivered = $logs->sum('quantity');

                $reportData[] = [
                    'registration_number' => $vehicle->registration_number,
                    'driver' => $vehicle->driver,
                    'vehicle_type' => $vehicle->vehicle_type,
                    'total_distance_travelled' => $totalDistanceTravelled,
                    'total_fuel_used' => $totalFuelUsed,
                    'total_material_delivered' => $totalMaterialDelivered,
                ];
            }

            if (empty($reportData)) {
                return back()->with('error', 'No information found for the selected month and year.');
            }

            if ($format === 'pdf') {
                return $this->generateAllPDF($reportData, $month, $year);
            } elseif ($format === 'csv') {
                return $this->generateAllCSV($reportData, $month, $year);
            }

            return back()->with('error', 'Invalid format selected.');
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while generating the report. Please try again.');
        }
    }

    private function generateAllPDF($reportData, $month, $year) {
        $pdf = PDF::loadView('reports.all_pdf', compact('reportData', 'month', 'year'));
        return $pdf->download("all_vehicles_report_{$month}_{$year}.pdf");
    }

    private function generateAllCSV($reportData, $month, $year) {
        try {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $title = "All Vehicles Monthly Report - {$month}/{$year}";
            $sheet->setCellValue('A1', $title);

            // Merge cells for the title and center it
            $sheet->mergeCells('A1:F1');
            $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);

            $sheet->setCellValue('A2', 'Registration Number')
                ->setCellValue('B2', 'Driver')
                ->setCellValue('C2', 'Vehicle Type')
                ->setCellValue('D2', 'Total Distance Travelled (Km)')
                ->setCellValue('E2', 'Total Fuel Used (Litres)')
                ->setCellValue('F2', 'Total Material Delivered (Tonnes)');

            $headerStyle = [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D3D3D3']]
            ];
            $sheet->getStyle('A2:F2')->applyFromArray($headerStyle);

            // Add data rows
            $row = 3;
            $totalDistanceTravelled = 0;
            $totalFuelUsed = 0;
            $totalMaterialDelivered = 0;

            foreach ($reportData as $data) {
                $sheet->setCellValue('A' . $row, $data['registration_number'])
                    ->setCellValue('B' . $row, $data['driver'])
                    ->setCellValue('C' . $row, $data['vehicle_type'])
                    ->setCellValue('D' . $row, $data['total_distance_travelled'])
                    ->setCellValue('E' . $row, $data['total_fuel_used'])
                    ->setCellValue('F' . $row, $data['total_material_delivered']);

                // Update totals
                $totalDistanceTravelled += $data['total_distance_travelled'];
                $totalFuelUsed += $data['total_fuel_used'];
                $totalMaterialDelivered += $data['total_material_delivered'];

                $row++;
            }

            // summary section
            $summaryRow = $row + 2;
            $sheet->setCellValue('A' . $summaryRow, 'Summary')
                ->setCellValue('D' . $summaryRow, 'Total Distance Travelled By All Vehicles:')
                ->setCellValue('E' . $summaryRow,  number_format($totalDistanceTravelled, 2) . ' Km')
                ->setCellValue('D' . ($summaryRow + 1), 'Total Fuel Used:')
                ->setCellValue('E' . ($summaryRow + 1), number_format($totalFuelUsed, 2) . ' Litres')
                ->setCellValue('D' . ($summaryRow + 2), 'Total Material Delivered:')
                ->setCellValue('E' . ($summaryRow + 2), number_format($totalMaterialDelivered, 2) . ' Tonnes');

            // Style summary section
            $summaryStyle = [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
            ];
            $sheet->getStyle('A' . $summaryRow . ':F' . ($summaryRow + 2))->applyFromArray($summaryStyle);

            foreach (range('A', 'F') as $column) {
                $sheet->getColumnDimension($column)->setAutoSize(true);
            }

            $filename = "all_vehicles_report_{$month}_{$year}.xlsx";
            $filePath = storage_path("app/{$filename}");
            $writer = new Xlsx($spreadsheet);
            $writer->save($filePath);

            return response()->download($filePath)->deleteFileAfterSend();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('error', 'Failed to Generate CSV file. Please try again.')->withInput();
        }
    }

    public function generate(Request $request) {
        $request->validate([
            'month' => 'required|numeric|min:1|max:12',
            'year' => 'required|numeric|min:2000|max:' . date('Y'),
            'format' => 'required|in:csv,pdf'
        ]);

        try {
            $vehicle = Vehicle::find($request->vehicle_id);

            if (!$vehicle) {
                return back()->with('error', 'Vehicle not found.');
            }

            $month = $request->month;
            $year = $request->year;
            $format = $request->format;

            $data = $vehicle->vehicleLogs()
                ->whereMonth('departure_date', $month)
                ->whereYear('departure_date', $year)
                ->orderBy('departure_date', 'asc')
                ->get();

            if ($data->isEmpty()) {
                return back()->with('error', 'No information found for the selected month and year.');
            }

            if ($format === 'pdf') {
                return $this->generatePDF($data, $vehicle, $month, $year);
            } elseif ($format === 'csv') {
                return $this->generateCSV($data, $vehicle, $month, $year);
            }

            return back()->with('error', 'Invalid format selected.');
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while generating the report. Please try again.');
        }
    }

    private function generatePDF($data, Vehicle $vehicle, $month, $year) {
        $pdf = PDF::loadView('reports.pdf', compact('data', 'vehicle', 'month', 'year'));
        return $pdf->download("vehicle_report_{$vehicle->registration_number}_{$month}_{$year}.pdf");
    }

    private function generateCSV($data, Vehicle $vehicle, $month, $year) {
        try {
            // Create a new Spreadsheet object
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Set the title
            $title = "{$vehicle->registration_number} - {$vehicle->driver} - {$vehicle->vehicle_type} - {$month}/{$year}";
            $sheet->setCellValue('A1', $title);

            // Merge cells for the title and center it
            $sheet->mergeCells('A1:K1');
            $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);

            // Add headers
            $sheet->setCellValue('A2', '#')
                ->setCellValue('B2', 'Departure Date')
                ->setCellValue('C2', 'Return Date')
                ->setCellValue('D2', 'Start Km')
                ->setCellValue('E2', 'Close Km')
                ->setCellValue('F2', 'Distance Travelled')
                ->setCellValue('G2', 'Location')
                ->setCellValue('H2', 'Material Delivered')
                ->setCellValue('I2', 'Material Qty (tonnes)')
                ->setCellValue('J2', 'Fuel Logs')
                ->setCellValue('K2', 'Total Fuel Used (Litres)');

            // Style headers
            $headerStyle = [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D3D3D3']]
            ];
            $sheet->getStyle('A2:K2')->applyFromArray($headerStyle);

            // Add data rows
            $row = 3;
            $totalFuelUsed = 0;
            $totalDistanceTravelled = 0;
            $totalMaterialDelivered = 0;

            foreach ($data as $log) {
                $fuelLogs = $log->fuelLogs->map(function ($fuelLog) {
                    return "{$fuelLog->litres_added}L at {$fuelLog->refuel_location}";
                })->implode(' | ');

                $departureDate = $log->departure_date
                    ? Carbon::createFromFormat('Y-m-d', $log->departure_date)->format('Y/m/d')
                    : '-';

                $returnDate = $log->return_date
                    ? Carbon::createFromFormat('Y-m-d', $log->return_date)->format('Y/m/d')
                    : '-';

                $distanceTravelled = $log->distance_travelled ?? 0;
                $materialDelivered = $log->quantity ?? 0;

                $sheet->setCellValue('A' . $row, $row - 2)
                    ->setCellValue('B' . $row, $departureDate)
                    ->setCellValue('C' . $row, $returnDate)
                    ->setCellValue('D' . $row, $log->start_kilometers)
                    ->setCellValue('E' . $row, $log->end_kilometers ?? 0)
                    ->setCellValue('F' . $row, $distanceTravelled)
                    ->setCellValue('G' . $row, $log->location)
                    ->setCellValue('H' . $row, $log->material_delivered ?? '-')
                    ->setCellValue('I' . $row, $materialDelivered)
                    ->setCellValue('J' . $row, $fuelLogs ?: 'No fuel data')
                    ->setCellValue('K' . $row, number_format($log->fuelLogs->sum('litres_added'), 2));

                // Update totals
                $totalFuelUsed += $log->fuelLogs->sum('litres_added');
                $totalDistanceTravelled += $distanceTravelled;
                $totalMaterialDelivered += $materialDelivered;

                $row++;
            }

            // summary section
            $summaryRow = $row + 2;
            $sheet->setCellValue('A' . $summaryRow, 'Summary')
                ->setCellValue('F' . $summaryRow, 'Total Distance Travelled:')
                ->setCellValue('G' . $summaryRow,  number_format($totalDistanceTravelled, 2) . ' Km')
                ->setCellValue('F' . ($summaryRow + 1), 'Total Fuel Used:')
                ->setCellValue('G' . ($summaryRow + 1), number_format($totalFuelUsed, 2) . ' Litres')
                ->setCellValue('F' . ($summaryRow + 2), 'Total Material Delivered:')
                ->setCellValue('G' . ($summaryRow + 2), number_format($totalMaterialDelivered, 2) . ' Tonnes');

            // Style summary section
            $summaryStyle = [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
            ];
            $sheet->getStyle('A' . $summaryRow . ':G' . ($summaryRow + 2))->applyFromArray($summaryStyle);

            // Auto-size columns
            foreach (range('A', 'K') as $column) {
                $sheet->getColumnDimension($column)->setAutoSize(true);
            }

            // Save the file
            $filename = "{$vehicle->registration_number}_{$month}_{$year}_vehicle_report.xlsx";
            $filePath = storage_path("app/{$filename}");
            $writer = new Xlsx($spreadsheet);
            $writer->save($filePath);

            return response()->download($filePath)->deleteFileAfterSend();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('error', 'Failed to Generate CSV file. Please try again.')->withInput();
        }
    }
}
