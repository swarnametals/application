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

    <small class="text-danger">Inputs marked with an asterisk (<span class="text-danger"> * </span>) are mandatory</small>

    <form action="{{ route('employees.store') }}" method="POST">
        @csrf

        <!-- Personal Details Section -->
        <div class="card mb-4">
            <div class="card-header text-white" style="background-color:#510404">
                <h5 class="mb-0">Personal Details</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="employee_full_name">Full Name<span class="text-danger">*</span></label>
                            <input type="text" id="employee_full_name" name="employee_full_name" class="form-control" value="{{ old('employee_full_name') }}" placeholder="Example: John Phiri" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone_number">Phone Number<span class="text-danger">*</span></label>
                            <input type="text" id="phone_number" name="phone_number" class="form-control" value="{{ old('phone_number') }}" placeholder="Example: 0971234567">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Example: johnphiri@gmail.com">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address">Address<span class="text-danger">*</span></label>
                            <input type="text" id="address" name="address" class="form-control" value="{{ old('address') }}" placeholder="Example: 123 Chimwemwe, Kitwe" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nationality">Nationality<span class="text-danger">*</span></label>
                            <input type="text" id="nationality" name="nationality" class="form-control" value="{{ old('nationality') }}" placeholder="Example: Zambian" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date_of_joining">Date of Joining<span class="text-danger">*</span></label>
                            <input type="date" id="date_of_joining" name="date_of_joining" class="form-control" value="{{ old('date_of_joining') }}" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="employee_id">Employee ID<span class="text-danger">*</span></label>
                            <input type="text" id="employee_id" name="employee_id" class="form-control" value="{{ old('employee_id') }}" placeholder="Example: SM004/PT003" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nrc_or_passport_number">NRC/Passport Number<span class="text-danger">*</span></label>
                            <input type="text" id="nrc_or_passport_number" name="nrc_or_passport_number" class="form-control" value="{{ old('nrc_or_passport_number') }}" placeholder="Example: 123456/78/1" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="department">Department<span class="text-danger">*</span></label>
                            <input type="text" id="department" name="department" class="form-control" value="{{ old('department') }}" placeholder="Example: Finance" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="designation">Designation<span class="text-danger">*</span></label>
                            <input type="text" id="designation" name="designation" class="form-control" value="{{ old('designation') }}" placeholder="Example: Accountant" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tpin_number">TPIN Number</label>
                            <input type="text" id="tpin_number" name="tpin_number" class="form-control" value="{{ old('tpin_number') }}" placeholder="Example: 123456789">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="grade">Grade</label>
                            <input type="text" id="grade" name="grade" class="form-control" value="{{ old('grade') }}" placeholder="Example: Grade 1">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Salary Details Section -->
        <div class="card mb-4">
            <div class="card-header text-white" style="background-color:#510404">
                <h5 class="mb-0">Salary Details</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="basic_salary">Basic Salary<span class="text-danger">*</span></label>
                            <input type="number" id="basic_salary" name="basic_salary" class="form-control" value="{{ old('basic_salary') }}" placeholder="Example: 5000" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="other_allowances">Other Allowances</label>
                            <input type="number" id="other_allowances" name="other_allowances" class="form-control" value="{{ old('other_allowances') }}" placeholder="Example: 200">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Details Section -->
        <div class="card mb-4">
            <div class="card-header text-white" style="background-color:#510404">
                <h5 class="mb-0">Payment Details</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="payment_method">Payment Method<span class="text-danger">*</span></label>
                            <select id="payment_method" name="payment_method" class="form-control" required>
                                <option value="">Select Payment Method</option>
                                <option value="Bank" {{ old('payment_method') == 'Bank' ? 'selected' : '' }}>Bank</option>
                                <option value="MTN Mobile Money" {{ old('payment_method') == 'MTN Mobile Money' ? 'selected' : '' }}>MTN Mobile Money</option>
                                <option value="Airtel Mobile Money" {{ old('payment_method') == 'Airtel Mobile Money' ? 'selected' : '' }}>Airtel Mobile Money</option>
                                <option value="Zamtel Mobile Money" {{ old('payment_method') == 'Zamtel Mobile Money' ? 'selected' : '' }}>Zamtel Mobile Money</option>
                                <option value="Cash" {{ old('payment_method') == 'Cash' ? 'selected' : '' }}>Cash</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="social_security_number">Social Security Number</label>
                            <input type="text" id="social_security_number" name="social_security_number" class="form-control" value="{{ old('social_security_number') }}" placeholder="Example: SSN123456">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bank Details Section -->
        <div class="card mb-4">
            <div class="card-header text-white" style="background-color:#510404">
                <h5 class="mb-0">Bank Details</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="account_name">Account Name</label>
                            <input type="text" id="account_name" name="account_name" class="form-control" value="{{ old('account_name') }}" placeholder="Example: John Phiri">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ifsc_code">IFSC Code</label>
                            <input type="text" id="ifsc_code" name="ifsc_code" class="form-control" value="{{ old('ifsc_code') }}" placeholder="Example: IFSC001">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bank_name">Bank Name</label>
                            <input type="text" id="bank_name" name="bank_name" class="form-control" value="{{ old('bank_name') }}" placeholder="Example: Indo Zambia Bank">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="branch_name">Branch Name</label>
                            <input type="text" id="branch_name" name="branch_name" class="form-control" value="{{ old('branch_name') }}" placeholder="Example: Kitwe Branch">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bank_address">Bank Address</label>
                            <input type="text" id="bank_address" name="bank_address" class="form-control" value="{{ old('bank_address') }}" placeholder="Example: 123 Town Center, Kitwe">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bank_telephone_number">Bank Telephone Number</label>
                            <input type="text" id="bank_telephone_number" name="bank_telephone_number" class="form-control" value="{{ old('bank_telephone_number') }}" placeholder="Example: 0211123456">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bank_account_number">Bank Account Number</label>
                            <input type="text" id="bank_account_number" name="bank_account_number" class="form-control" value="{{ old('bank_account_number') }}" placeholder="Example: 1234567890">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- References Section -->
        <div class="card mb-4">
            <div class="card-header text-white" style="background-color:#510404">
                <h5 class="mb-0">References</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="references">References</label>
                            <div id="references-container">
                                @if (old('references'))
                                    @foreach (old('references') as $index => $reference)
                                        <div class="reference-group mb-3">
                                            <input type="text" name="references[{{ $index }}][name]" class="form-control mb-2" placeholder="Reference Name" value="{{ $reference['name'] }}">
                                            <input type="text" name="references[{{ $index }}][phone_number]" class="form-control" placeholder="Reference Phone Number" value="{{ $reference['phone_number'] }}">
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <button type="button" id="add-reference" class="btn btn-secondary mt-2">Add Reference</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Add Employee</button>
            <a href="{{ route('employees.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<!-- JavaScript to Add More Reference Fields -->
<script>
    document.getElementById('add-reference').addEventListener('click', function () {
        const container = document.getElementById('references-container');
        const index = container.children.length;
        const div = document.createElement('div');
        div.classList.add('reference-group', 'mb-3');
        div.innerHTML = `
            <input type="text" name="references[${index}][name]" class="form-control mb-2" placeholder="Reference Name">
            <input type="text" name="references[${index}][phone_number]" class="form-control" placeholder="Reference Phone Number">
        `;
        container.appendChild(div);
    });
</script>
@endsection
