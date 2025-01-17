<?php
namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\EmployeeImport;
use App\Models\Employee;
use App\Models\Payslip;

class PayslipController extends Controller {
    public function showUploadForm() {
        return view('payslips.upload');
    }

    public function upload(Request $request) {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,csv',
        ]);

        try {
            $import = new \App\Imports\EmployeeImport();

            Excel::import($import, $request->file('file'));

            $failures = $import->getFailures();

            if (count($failures) > 0) {
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

        $zip = new \ZipArchive();
        $zipFileName = 'payslips_' . now()->format('Y_m_d_H_i_s') . '.zip';
        $zipFilePath = storage_path($zipFileName);

        if ($zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            return redirect()->back()->with('error', 'Could not create ZIP file.');
        }

        foreach ($employees as $employee) {
            $grossEarnings = $employee->basic_salary
                + $employee->housing_allowance
                + $employee->transport_allowance
                + $employee->other_allowances
                + $employee->overtime_pay
                + $employee->lunch_allowance;

            $napsa = $grossEarnings * 0.05;
            $nhima = $employee->basic_salary * 0.01;

            if ($grossEarnings > 9200) {
                $zra = (5100 * 0) + (2000 * 0.2) + (2100 * 0.3) + (($grossEarnings - 9200) * 0.37);
            } elseif ($grossEarnings > 7100) {
                $zra = (5100 * 0) + (2000 * 0.2) + (($grossEarnings - 7100) * 0.3);
            } elseif ($grossEarnings > 5100) {
                $zra = (5100 * 0) + (($grossEarnings - 5100) * 0.2);
            } else {
                $zra = 0;
            }

            $totalDeductions = $employee->loan_recovery + $employee->other_deductions + $zra + $nhima + $napsa;
            $netPay = $grossEarnings - $totalDeductions;

            $payslipData = [
                'gross_pay_ytd' => Payslip::where('employee_id', $employee->id)->sum('gross_earnings'),
                'tax_paid_ytd' => Payslip::where('employee_id', $employee->id)->sum('tax_deduction'),
                'napsa_ytd' => Payslip::where('employee_id', $employee->id)->sum('napsa_contribution'),
                'pension_ytd' => Payslip::where('employee_id', $employee->id)->sum('napsa_contribution'),
                'basic_salary' => $employee->basic_salary,
                'housing_allowance' => $employee->housing_allowance,
                'health_insurance' => $nhima,
                'napsa' => $napsa,
                'transport_allowance' => $employee->transport_allowance,
                'other_allowances' => $employee->other_allowances,
                'overtime_pay' => $employee->overtime_pay,
                'overtime_hours' => $employee->overtime_hours,
                'lunch_allowance' => $employee->lunch_allowance,
                'loan_recovery' => $employee->loan_recovery,
                'other_deductions' => $employee->other_deductions,
                'total_earnings' => $grossEarnings,
                'total_deductions' => $totalDeductions,
                'net_pay' => $netPay,
                'payment_method' => $employee->payment_method,
                'social_security_number' => $employee->social_security_number,
                'bank_account_number' => $employee->bank_account_number,
            ];

            $pdf = Pdf::loadView('payslips.template', compact('employee', 'payslipData'));
            $fileName = "payslip_{$employee->name}.pdf";

            $zip->addFromString($fileName, $pdf->output());
        }

        $zip->close();

        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }
}
