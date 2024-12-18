<?php
namespace App\Imports;

use App\Models\Employee;
use App\Models\Payslip;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Validators\Failure;

class EmployeeImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure {
    use SkipsFailures;

    protected $failures = [];

    public function model(array $row) {
        // Create or update the employee record
        $employee = Employee::updateOrCreate(
            ['id_number' => $row['id_number']], // Match by id_number
            [
                'name' => $row['name'],
                'position' => $row['position'],
                'grade' => $row['grade'],
                'team' => $row['team'],
                'basic_salary' => is_numeric($row['basic_salary']) ? $row['basic_salary'] : 0,
                'housing_allowance' => is_numeric($row['housing_allowance']) ? $row['housing_allowance'] : 0,
                'transport_allowance' => is_numeric($row['transport_allowance']) ? $row['transport_allowance'] : 180,
                'other_allowances' => is_numeric($row['other_allowances']) ? $row['other_allowances'] : 0,
                'overtime_hours' => is_numeric($row['overtime_hours']) ? $row['overtime_hours'] : 0,
                'overtime_pay' => is_numeric($row['overtime_pay']) ? $row['overtime_pay'] : 0,
                'lunch_allowance' => is_numeric($row['lunch_allowance']) ? $row['lunch_allowance'] : 200,
                'loan_recovery' => is_numeric($row['loan_recovery']) ? $row['loan_recovery'] : 0,
                'other_deductions' => is_numeric($row['other_deductions']) ? $row['other_deductions'] : 0,
                'payment_method' => $row['payment_method'],
                'social_security_number' => $row['social_security_number'],
                'bank_name' => $row['bank_name'],
                'branch_name' => $row['branch_name'],
                'bank_account_number' => $row['bank_account_number'],
            ]
        );

        // Calculate gross earnings
        $grossEarnings = $employee->basic_salary
            + $employee->housing_allowance
            + $employee->transport_allowance
            + $employee->other_allowances
            + $employee->overtime_pay
            + $employee->lunch_allowance;

        // Calculate deductions
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

        // Create or update the payslip record
        Payslip::updateOrCreate(
            ['employee_id' => $employee->id],
            [
                'gross_earnings' => $grossEarnings,
                'total_deductions' => $totalDeductions,
                'net_pay' => $netPay,
                'napsa_contribution' => $napsa,
                'nhima' => $nhima,
                'tax_deduction' => $zra,
            ]
        );

        return null;
    }

    public function rules(): array {
        return [
            'name' => 'required|string',
            'id_number' => 'required|string',
            'position' => 'required|string',
            'grade' => 'required|string',
            'team' => 'nullable|string',
            'basic_salary' => 'required|numeric',
            'housing_allowance' => 'nullable|numeric',
            'transport_allowance' => 'nullable|numeric',
            'other_allowances' => 'nullable|numeric',
            'overtime_hours' => 'nullable|numeric',
            'overtime_pay' => 'nullable|numeric',
            'lunch_allowance' => 'nullable|numeric',
            'loan_recovery' => 'nullable|numeric',
            'other_deductions' => 'nullable|numeric',
            'payment_method' => 'required|string',
            'social_security_number' => 'nullable|string',
            'bank_name' => 'nullable|string',
            'branch_name' => 'nullable|string',
            'bank_account_number' => 'nullable|string',
        ];
    }

    public function getFailures() {
        return $this->failures;
    }
}
