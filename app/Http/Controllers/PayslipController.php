<?php
namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\EmployeeImport;
use App\Models\Employee;

class PayslipController extends Controller {
    public function showUploadForm() {
        return view('payslips.upload');
    }

    public function upload(Request $request) {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,csv',
        ]);

        try {
            // Create a new import instance
            $import = new \App\Imports\EmployeeImport();

            // Import the file
            Excel::import($import, $request->file('file'));

            // Retrieve failures using the new method
            $failures = $import->getFailures();

            if (count($failures) > 0) {
                // Log details of failed rows
                foreach ($failures as $failure) {
                    \Log::warning("Row {$failure->row()}: " . implode(', ', $failure->errors()));
                }

                return redirect()->route('employees.index')
                    ->with('warning', 'Some rows failed to process. Check logs for details.');
            }

            return redirect()->route('employees.index')
                ->with('success', 'File uploaded and data processed successfully.');
        } catch (\Exception $e) {
            \Log::error('Error during import: ' . $e->getMessage());

            return redirect()->route('payslips.upload')
                ->with('error', 'File processing failed. Please check the file and try again.');
        }
    }

    public function generate() {
            $employees = Employee::all();

            foreach ($employees as $employee) {
                $pdf = Pdf::loadView('payslips.template', compact('employee'));

                return $pdf->download("payslip_{$employee->id_number}_payslip.pdf");
            }

        return redirect()->back()->with('success', 'Payslips generated successfully.');
    }
}
