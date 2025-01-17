@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex flex-wrap gap-2 mb-3">
        <a href="{{ route('employees.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
        <a href="{{ route('employees.generatePayslip', $employee->id) }}" class="btn btn-primary"><i class="fas fa-print"></i> Print Payslip</a>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h3>Employee Details</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Name:</strong> {{ $employee->name }}</p>
                    <p><strong>ID Number:</strong> {{ $employee->id_number }}</p>
                    <p><strong>Position:</strong> {{ $employee->position }}</p>
                    <p><strong>Grade:</strong> {{ $employee->grade }}</p>
                    <p><strong>Team:</strong> {{ $employee->team }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Basic Salary:</strong> {{ number_format($employee->basic_salary, 2) }} ZMW</p>
                    <p><strong>Housing Allowance:</strong> {{ number_format($employee->housing_allowance, 2) }} ZMW</p>
                    <p><strong>Transport Allowance:</strong> {{ number_format($employee->transport_allowance, 2) }} ZMW</p>
                    <p><strong>Other Allowances:</strong> {{ number_format($employee->other_allowances, 2) }} ZMW</p>
                    <p><strong>Overtime Hours:</strong> {{ number_format($employee->overtime_hours, 2) }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Overtime Pay:</strong> {{ number_format($employee->overtime_pay, 2) }} ZMW</p>
                    <p><strong>Lunch Allowance:</strong> {{ number_format($employee->lunch_allowance, 2) }} ZMW</p>
                    <p><strong>Payment Method:</strong> {{ $employee->payment_method }}</p>
                    <p><strong>Bank Account Number:</strong> {{ $employee->bank_account_number }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Bank Name:</strong> {{ $employee->bank_name }}</p>
                    <p><strong>Branch Name:</strong> {{ $employee->branch_name }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Payslips</h3>
        </div>
        <div class="card-body">
            @if($employee->payslips->isEmpty())
                <p>No payslips available for this employee.</p>
            @else
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Gross Earnings</th>
                            <th>Total Deductions</th>
                            <th>Net Pay</th>
                            <th>NAPSA Contribution</th>
                            <th>NHIMA</th>
                            <th>Tax Deduction</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employee->payslips as $payslip)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ number_format($payslip->gross_earnings, 2) }} ZMW</td>
                                <td>{{ number_format($payslip->total_deductions, 2) }} ZMW</td>
                                <td>{{ number_format($payslip->net_pay, 2) }} ZMW</td>
                                <td>{{ number_format($payslip->napsa_contribution, 2) }} ZMW</td>
                                <td>{{ number_format($payslip->nhima, 2) }} ZMW</td>
                                <td>{{ number_format($payslip->tax_deduction, 2) }} ZMW</td>
                                <td>{{ $payslip->created_at->format('d-m-Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
