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

    {{-- <a href="{{ route('employees.generatePayslips') }}" class="btn btn-primary mb-3">
        Download All Payslips
    </a> --}}

    @if($employees->isEmpty())
        <p>No employees available.</p>
    @else
    <table class="table table-bordered">
        <thead>
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
                    <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-info btn-sm">
                        View
                    </a>
                    <a href="{{ route('employees.generatePayslip', $employee->id) }}" class="btn btn-primary btn-sm">
                        Print Payslip
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @endif

    <div class="d-flex justify-content-center">
        {{ $employees->links() }}
    </div>

    <a href="{{ route('employees.create') }}" class="btn btn-success">Add New Employee</a>
    <a href="{{ route('payslips.upload') }}" class="btn btn-success">Add Employees With An Excel Sheet</a>

</div>
@endsection
