@extends('layouts.app')

@section('title', 'Employees')

@section('content')
<div class="container mt-5">
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(session()->has('warning'))
        <div class="alert alert-warning">
            {{ session('warning') }}
        </div>
    @endif

    <div class="d-flex flex-wrap gap-2 mb-3">
        <a href="{{ route('dashboards.admin') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
        <a href="{{ route('payslips.generate') }}" class="btn btn-primary">Download All Payslips</a>
    </div>

    @if($employees->isEmpty())
        <p class="text-center">No employees available.</p>
    @else
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>ID Number</th>
                    <th>Position</th>
                    <th>Team</th>
                    <th>Basic Pay</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($employees as $employee)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->id_number }}</td>
                    <td>{{ $employee->position }}</td>
                    <td>{{ $employee->team }}</td>
                    <td>{{ number_format($employee->basic_salary, 2) }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-info btn-sm">
                                View
                            </a>
                            <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-warning btn-sm">
                                Edit
                            </a>
                            <a href="{{ route('employees.generatePayslip', $employee->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-print"></i>
                                Print Payslip
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <div class="d-flex flex-wrap gap-2 mt-3">
        <a href="{{ route('employees.create') }}" class="btn btn-success"><i class="fas fa-user-plus"></i> Add New Employee</a>
        <a href="{{ route('payslips.upload') }}" class="btn btn-success"> <i class="fas fa-upload"></i> Add Employees With An Excel Sheet</a>
    </div>
</div>
@endsection
