<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Payslip;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class EmployeeController extends Controller {
    public function index() {
        try {
            $employees = Employee::all();
            return view('employees.index', compact('employees'));
        } catch (\Exception $e) {
            // Log the error (optional, if you use Laravel's logging)
            \Log::error('Error fetching employees: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to load employees. Please try again later.');
        }
    }

    public function create() {
        try {
            return view('employees.create');
        } catch (\Exception $e) {
            \Log::error('Error loading create form: ' . $e->getMessage());
            return redirect()->route('employees.index')->with('error', 'Failed to load the create form. Please try again.');
        }
    }

    public function store(Request $request) {
        try {
            $validated = $request->validate([
                'employee_full_name' => 'required|string|max:255',
                'phone_number' => 'required|string|max:255',
                'email' => 'nullable|email|max:255',
                'address' => 'required|string|max:255',
                'nationality' => 'required|string|max:255',
                'date_of_joining' => 'required|date',
                'employee_id' => 'required|string|max:255|unique:employees',
                'tpin_number' => 'nullable|string|max:255',
                'nrc_or_passport_number' => 'required|string|max:255',
                'designation' => 'required|string|max:255',
                'department' => 'required|string|max:255',
                'grade' => 'nullable|string|max:255',
                'basic_salary' => 'required|numeric|min:0',
                'other_allowances' => 'nullable|numeric|min:0',
                'payment_method' => 'required|string|max:255',
                'social_security_number' => 'nullable|string|max:255',
                'account_name' => 'nullable|string|max:255',
                'ifsc_code' => 'nullable|string|max:255',
                'bank_name' => 'nullable|string|max:255',
                'branch_name' => 'nullable|string|max:255',
                'bank_address' => 'nullable|string|max:255',
                'bank_telephone_number' => 'nullable|string|max:255',
                'bank_account_number' => 'nullable|string|max:255',
                'references' => 'nullable|array',
                'references.*.name' => 'required_with:references|string|max:255',
                'references.*.phone_number' => 'required_with:references|string|max:255',
            ]);

            $validated['housing_allowance'] = $validated['basic_salary'] * 0.3; // 30% of basic salary
            $validated['transport_allowance'] = 200; // Fixed value
            $validated['food_allowance'] = 180; // Fixed value

            // Create employee
            $employee = Employee::create($validated);

            // Gross earnings calculation
            $grossEarnings = $employee->basic_salary
                + $employee->housing_allowance
                + $employee->transport_allowance
                + ($employee->other_allowances ?? 0)
                + $employee->food_allowance;

            // Deductions
            $napsa = $grossEarnings * 0.05; // NAPSA contribution (5% of gross earnings)
            $nhima = $employee->basic_salary * 0.01; // NHIMA contribution (1% of basic salary)

            //  ZRA tax
            if ($grossEarnings > 9200) {
                $zra = (5100 * 0) + (2000 * 0.2) + (2100 * 0.3) + (($grossEarnings - 9200) * 0.37);
            } elseif ($grossEarnings > 7100) {
                $zra = (5100 * 0) + (2000 * 0.2) + (($grossEarnings - 7100) * 0.3);
            } elseif ($grossEarnings > 5100) {
                $zra = (5100 * 0) + (($grossEarnings - 5100) * 0.2);
            } else {
                $zra = 0;
            }

            $totalDeductions = $zra + $nhima;

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

            return redirect()->route('employees.index')->with('success', 'Employee added successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            \Log::error('Error storing employee: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to add employee: ' . $e->getMessage())->withInput();
        }
    }

    public function show($employee) {
        try {
            $employee = Employee::with('payslips')->findOrFail($employee);
            return view('employees.show', compact('employee'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('employees.index')->with('error', 'Employee not found.');
        } catch (\Exception $e) {
            \Log::error('Error showing employee: ' . $e->getMessage());
            return redirect()->route('employees.index')->with('error', 'Failed to load employee details. Please try again.');
        }
    }

    public function edit(Employee $employee) {
        try {
            return view('employees.edit', compact('employee'));
        } catch (\Exception $e) {
            \Log::error('Error loading edit form: ' . $e->getMessage());
            return redirect()->route('employees.index')->with('error', 'Failed to load the edit form. Please try again.');
        }
    }

    public function update(Request $request, Employee $employee) {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'id_number' => "required|string|max:255|unique:employees,id_number,{$employee->id}",
                'position' => 'required|string|max:255',
                'grade' => 'required|string|max:255',
                'team' => 'nullable|string|max:255',
                'basic_salary' => 'required|numeric|min:0',
                'other_allowances' => 'required|numeric|min:0',
                'overtime_hours' => 'nullable|numeric|min:0',
                'overtime_pay' => 'nullable|numeric|min:0',
                'loan_recovery' => 'required|numeric|min:0',
                'other_deductions' => 'required|numeric|min:0',
                'days_worked' => 'required|numeric|min:0',
                'payment_method' => 'required|string|max:255',
                'social_security_number' => 'required|string|max:255',
                'bank_name' => 'nullable|string',
                'branch_name' => 'nullable|string',
                'bank_account_number' => 'nullable|string',
            ]);

            $validated['housing_allowance'] = $validated['basic_salary'] * 0.3; // 30% of basic salary
            $validated['lunch_allowance'] = 180; // Fixed value
            $validated['transport_allowance'] = 200; // Fixed value

            $employee->update($validated);

            $grossEarnings = $employee->basic_salary
                + $validated['housing_allowance']
                + $validated['transport_allowance']
                + $validated['other_allowances']
                + $validated['overtime_pay']
                + $validated['lunch_allowance'];

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

            $payslip = Payslip::where('employee_id', $employee->id)->first();

            if ($payslip) {
                $payslip->update([
                    'gross_earnings' => $grossEarnings,
                    'days_worked' => $validated['days_worked'],
                    'total_deductions' => $totalDeductions,
                    'net_pay' => $netPay,
                    'napsa_contribution' => $napsa,
                    'nhima' => $nhima,
                    'tax_deduction' => $zra,
                ]);
            } else {
                Payslip::create([
                    'employee_id' => $employee->id,
                    'gross_earnings' => $grossEarnings,
                    'days_worked' => $validated['days_worked'],
                    'total_deductions' => $totalDeductions,
                    'net_pay' => $netPay,
                    'napsa_contribution' => $napsa,
                    'nhima' => $nhima,
                    'tax_deduction' => $zra,
                ]);
            }

            return redirect()->route('employees.index')->with('success', 'Employee and payslip updated successfully.');
        } catch (\Exception $e) {
            \Log::error('Error updating employee: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An error occurred while updating the employee. Please try again later.');
        }
    }

    public function destroy(Employee $employee) {
        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }

    public function generatePayslip($employeeId) {
        $employee = Employee::findOrFail($employeeId);

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

        $pdf = Pdf::loadView('payslips.template',  compact('employee', 'payslipData'));

        return $pdf->download("{$employee->name}_payslip.pdf");
    }
}

