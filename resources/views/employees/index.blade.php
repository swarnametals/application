@extends('layouts.app')

@section('title', 'Employees')

@section('content')
<div class="container">
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
        {{-- <a href="{{ route('dashboards.admin') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Dashboard</a> --}}
        <a href="{{ route('employees.create') }}" class="btn btn-success" style="background-color:#510404; margin-left:6px; color: #fff;"><i class="fas fa-user-plus"></i> Add New Employee</a>
        {{-- <a href="{{ route('payslips.upload') }}" class="btn btn-success"> <i class="fas fa-upload"></i> Add Employees With An Excel Sheet</a> --}}
    </div>

    <form action="{{ route('employees.index') }}" method="GET" class="mb-3">
        <div class="row g-3">
            <div class="col-12 col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search by Name, Employee ID or Designation" value="{{ request('search') }}">
            </div>
            <div class="col-12 col-md-2">
                <button type="submit" class="btn btn-primary w-100">Search</button>
            </div>
            <div class="col-12 col-md-2">
                <a href="{{ route('employees.index') }}" class="btn btn-secondary w-100">Reset</a>
            </div>
        </div>
    </form>

    @if($employees->isEmpty())
        <p class="text-center">No employees available.</p>
    @else
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Employee ID</th>
                    <th>Designation</th>
                    <th>Department</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($employees as $employee)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $employee->employee_full_name }}</td>
                    <td>{{ $employee->employee_id }}</td>
                    <td>{{ $employee->designation }}</td>
                    <td>{{ $employee->department }}</td>
                    <td>
                        @if ($employee->status == 'Active')
                            <div class="btn btn-sm" style="background-color: #28a745; color: white; border-radius: 4px; padding: 0.25rem 0.5rem;">{{ $employee->status }}</div>
                        @elseif ($employee->status == 'Inactive')
                            <div class="btn btn-sm" style="background-color: #6c757d; color: white; border-radius: 4px; padding: 0.25rem 0.5rem;">{{ $employee->status }}</div>
                        @elseif ($employee->status == 'On Leave')
                            <div class="btn btn-sm" style="background-color: #ffc107; color: white; border-radius: 4px; padding: 0.25rem 0.5rem;">{{ $employee->status }}</div>
                        @elseif ($employee->status == 'Terminated')
                            <div class="btn btn-sm" style="background-color: #dc3545; color: white; border-radius: 4px; padding: 0.25rem 0.5rem;">{{ $employee->status }}</div>
                        @else
                            <div class="btn btn-sm" style="background-color: #6c757d; color: white; border-radius: 4px; padding: 0.25rem 0.5rem;">{{ $employee->status ?? 'N/A' }}</div>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i>
                            View Details
                        </a>
                        <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-warning btn-sm mt-2"><i class="fas fa-edit"></i>
                            Edit
                        </a>
                        {{-- <a href="{{ route('employees.generatePayslip', $employee->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-print"></i>
                            Print Payslip
                        </a> --}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @endif

</div>
@endsection
