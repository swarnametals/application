<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Payslip;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class EmployeeController extends Controller {
    public function index() {
        $employees = Employee::paginate(10);

        return view('employees.index', compact('employees'));
    }

    public function create() {
        return view('employees.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'id_number' => 'required|string|max:255|unique:employees',
            'position' => 'required|string|max:255',
            'grade' => 'required|string|max:255',
            'team' => 'nullable|string|max:255',
            'basic_salary' => 'required|numeric|min:0',
            'housing_allowance' => 'nullable|numeric|min:0',
            'transport_allowance' => 'nullable|numeric|min:0',
            'other_allowances' => 'nullable|numeric|min:0',
            'overtime_hours' => 'nullable|numeric|min:0',
            'overtime_pay' => 'nullable|numeric|min:0',
            'lunch_allowance' => 'nullable|numeric|min:0',
            'loan_recovery' => 'nullable|numeric|min:0',
            'other_deductions' => 'nullable|numeric|min:0',
            'payment_method' => 'required|string|max:255',
            'social_security_number' => 'required|string|max:255',
            'bank_name' => 'nullable|string',
            'branch_name' => 'nullable|string',
            'bank_account_number' => 'nullable|string',
        ]);

        // Create employee
        $employee = Employee::create($validated);

        // Calculate earnings and deductions
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

        $totalDeductions = $employee->loan_recovery + $employee->other_deductions + $zra + $nhima;
        $netPay = $grossEarnings - $totalDeductions;

        // Create payslip
        Payslip::create([
            'employee_id' => $employee->id,
            'gross_earnings' => $grossEarnings,
            'total_deductions' => $totalDeductions,
            'net_pay' => $netPay,
            'napsa_contribution' => $napsa,
            'nhima' => $nhima,
            'tax_deduction' => $zra,
        ]);

        return redirect()->route('employees.index')->with('success', 'Employee and payslip created successfully.');
    }

    public function show($employee) {
        $employee = Employee::with('payslips')->findOrFail($employee);

        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee) {
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'id_number' => "required|string|max:255|unique:employees,id_number,{$employee->id}",
            'position' => 'required|string|max:255',
            'team' => 'nullable|string|max:255',
            'basic_pay' => 'required|numeric|min:0',
            'hra' => 'nullable|numeric|min:0',
            'conveyance' => 'nullable|numeric|min:0',
            'medical' => 'nullable|numeric|min:0',
            'other_allowances' => 'nullable|numeric|min:0',
            'overtime_hours' => 'nullable|numeric|min:0',
            'overtime_pay' => 'nullable|numeric|min:0',
            'pf' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'loan_recovery' => 'nullable|numeric|min:0',
            'other_deductions' => 'nullable|numeric|min:0',
            'payment_mode' => 'required|string|max:255',
            'bank_details' => 'nullable|string',
            'bank_name' => 'nullable|string',
            'branch_name' => 'nullable|string',
        ]);

        $employee->update($validated);

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }

    // public function generatePayslip($employee) {
    //     $employee = Employee::findOrFail($employee);


    //     $payslipData = [
    //         'gross_pay_ytd' => 50000.00,
    //         'tax_paid_ytd' => 5000.00,
    //         'napsa_ytd' => 3000.00,
    //         'pension_ytd' => 2000.00,
    //         'leave_balance' => 15,
    //         'basic_pay' => 10000.00,
    //         'housing_allowance' => 2000.00,
    //         'transport_allowance' => 1500.00,
    //         'overtime_hours' => 10,
    //         'overtime_pay' => 1200.00,
    //         'other_allowances' => 500.00,
    //         'napsa_contribution' => 300.00,
    //         'tax_deduction' => 1000.00,
    //         'health_insurance' => 200.00,
    //         'other_deductions' => 150.00,
    //         'total_earnings' => 13200.00,
    //         'total_deductions' => 1650.00,
    //         'net_pay' => 11550.00,
    //         'payment_method' => 'Bank Transfer',
    //         'social_security_number' => '123-45-6789',
    //         'bank_account_number' => '987654321',
    //     ];

    //     $pdf = Pdf::loadView('payslips.template', compact('employee', 'payslipData'));

    //     return $pdf->download("{$employee->name}_payslip.pdf");
    // }

    public function generatePayslip($employeeId) {
        // work on leave balance and pension_ytd
        // overtime and hours
        $employee = Employee::findOrFail($employeeId);

        // Calculate earnings and deductions
        $grossEarnings = $employee->basic_salary
            + $employee->housing_allowance
            + $employee->transport_allowance
            + $employee->other_allowances
            + $employee->overtime_pay
            + $employee->lunch_allowance;

        $napsa = $grossEarnings * 0.05;
        $nhima = $employee->basic_salary * 0.01;

        // Tax calculation
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

        // Prepare payslip data
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

        $pdf = Pdf::loadView('payslips.template',  compact('employee', 'payslipData'));

        return $pdf->download("{$employee->name}_payslip.pdf");
    }
}

