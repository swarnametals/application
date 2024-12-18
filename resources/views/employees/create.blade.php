@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add New Employee</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('employees.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="id_number">ID Number</label>
                    <input type="text" id="id_number" name="id_number" class="form-control" value="{{ old('id_number') }}" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="position">Position</label>
                    <input type="text" id="position" name="position" class="form-control" value="{{ old('position') }}" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="grade">Grade</label>
                    <input type="text" id="grade" name="grade" class="form-control" value="{{ old('grade') }}" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="team">Team</label>
                    <input type="text" id="team" name="team" class="form-control" value="{{ old('team') }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="basic_salary">Basic Salary</label>
                    <input type="number" id="basic_salary" name="basic_salary" class="form-control" value="{{ old('basic_salary') }}" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="housing_allowance">Housing Allowance</label>
                    <input type="number" id="housing_allowance" name="housing_allowance" class="form-control" value="{{ old('housing_allowance') }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="transport_allowance">Transport Allowance</label>
                    <input type="number" id="transport_allowance" name="transport_allowance" class="form-control" value="{{ old('transport_allowance') }}">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="other_allowances">Other Allowances</label>
                    <input type="number" id="other_allowances" name="other_allowances" class="form-control" value="{{ old('other_allowances') }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="lunch_allowance">Lunch Allowance</label>
                    <input type="number" id="lunch_allowance" name="lunch_allowance" class="form-control" value="{{ old('lunch_allowance') }}">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="overtime_hours">Overtime Hours</label>
                    <input type="number" id="overtime_hours" name="overtime_hours" class="form-control" value="{{ old('overtime_hours') }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="overtime_pay">Over Time Pay</label>
                    <input type="number" id="overtime_pay" name="overtime_pay" class="form-control" value="{{ old('overtime_pay') }}">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="loan_recovery">Loan Recovery</label>
                    <input type="number" id="loan_recovery" name="loan_recovery" class="form-control" value="{{ old('loan_recovery') }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="other_deductions">Other Deductions</label>
                    <input type="number" id="other_deductions" name="other_deductions" class="form-control" value="{{ old('other_deductions') }}">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="payment_method">Payment Method</label>
                    <select id="payment_method" name="payment_method" class="form-control" required>
                        <option value="Bank" {{ old('payment_method') == 'Bank' ? 'selected' : '' }}>Bank</option>
                        <option value="MTN Mobile Money" {{ old('payment_method') == 'MTN Mobile Money' ? 'selected' : '' }}>MTN Mobile Money</option>
                        <option value="Airtel Mobile Money" {{ old('payment_method') == 'Airtel Mobile Money' ? 'selected' : ''}} >Airtel Mobile Money</option>
                        <option value="Zamtel Mobile Money" {{ old('payment_method') == 'Zamtel Mobile Money' ? 'selected' : ''}} >Zamtel Mobile Money</option>
                        <option value="Cash" {{ old('payment_method') == 'Cash' ? 'selected' : '' }}>Cash</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="social_security_number">Social Security Number</label>
                    <input type="text" id="social_security_number" name="social_security_number" class="form-control" value="{{ old('social_security_number') }}" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="bank_name">Bank Name</label>
                    <input type="text" id="bank_name" name="bank_name" class="form-control" value="{{ old('bank_name') }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="branch_name">Branch Name</label>
                    <input type="text" id="branch_name" name="branch_name" class="form-control" value="{{ old('branch_name') }}">
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="bank_account_number">Bank Account Number</label>
                    <input type="text" id="bank_account_number" name="bank_account_number" class="form-control" value="{{ old('bank_account_number') }}">
                </div>
            </div>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Add Employee</button>
        </div>
    </form>
</div>
@endsection
