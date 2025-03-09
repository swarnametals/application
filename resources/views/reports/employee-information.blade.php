<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Information - {{ $employee->employee_full_name }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 10mm; /* Reduced from 20mm */
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 9pt; /* Reduced from 12pt */
            line-height: 1.2; /* Reduced from 1.5 */
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 190mm; /* Fits A4 width with margins */
        }

        h1 {
            font-size: 14pt; /* Reduced from 18pt */
            text-align: center;
            margin: 10px 0; /* Reduced from 20px */
            color: #510404;
        }

        h2 {
            font-size: 11pt; /* Reduced from 14pt */
            color: #510404;
            margin: 8px 0 4px; /* Tightened spacing */
            border-bottom: 1px solid #510404;
            padding-bottom: 2px;
        }

        .section {
            margin-bottom: 8px; /* Reduced from 20px */
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 5px; /* Reduced from 10px */
        }

        .col-md-6 {
            width: 48%;
            margin-right: 2%;
        }

        .col-md-6:last-child {
            margin-right: 0;
        }

        p {
            margin: 2px 0; /* Reduced from 5px */
        }

        strong {
            font-weight: bold;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px; /* Reduced from 10px */
        }

        th, td {
            border: 1px solid #ccc;
            padding: 4px; /* Reduced from 8px */
            text-align: left;
            font-size: 8pt; /* Reduced from 11pt */
        }

        th {
            background-color: #510404;
            color: white;
        }

        .status-active {
            background-color: #28a745;
            color: white;
            padding: 1px 4px; /* Reduced from 2px 8px */
            border-radius: 3px;
            display: inline-block;
        }

        .status-inactive {
            background-color: #6c757d;
            color: white;
            padding: 1px 4px;
            border-radius: 3px;
            display: inline-block;
        }

        .status-on-leave {
            background-color: #ffc107;
            color: white;
            padding: 1px 4px;
            border-radius: 3px;
            display: inline-block;
        }

        .status-terminated {
            background-color: #dc3545;
            color: white;
            padding: 1px 4px;
            border-radius: 3px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Employee Information: {{ $employee->employee_full_name }} (ID: {{ $employee->employee_id }})</h1>

        <!-- Personal Information -->
        <div class="section">
            <h2>Personal Information</h2>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>First Name:</strong> {{ $employee->first_name }}</p>
                    <p><strong>Middle Name:</strong> {{ $employee->middle_name ?? 'N/A' }}</p>
                    <p><strong>Surname:</strong> {{ $employee->surname_name }}</p>
                    <p><strong>Full Name:</strong> {{ $employee->employee_full_name }}</p>
                    <p><strong>Sex:</strong> {{ $employee->sex }}</p>
                    <p><strong>Date of Birth:</strong> {{ $employee->date_of_birth ? $employee->date_of_birth->format('Y-m-d') : 'N/A' }}</p>
                    <p><strong>Marital Status:</strong> {{ $employee->marital_status }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Phone Number:</strong> {{ $employee->phone_number }}</p>
                    <p><strong>Email:</strong> {{ $employee->email ?? 'N/A' }}</p>
                    <p><strong>Address:</strong> {{ $employee->address }}</p>
                    <p><strong>Town:</strong> {{ $employee->town }}</p>
                    <p><strong>Nationality:</strong> {{ $employee->nationality }}</p>
                    <p>
                        <strong>Status:</strong>
                        @if ($employee->status == 'Active')
                            <span class="status-active">{{ $employee->status }}</span>
                        @elseif ($employee->status == 'Inactive')
                            <span class="status-inactive">{{ $employee->status }}</span>
                        @elseif ($employee->status == 'On Leave')
                            <span class="status-on-leave">{{ $employee->status }}</span>
                        @elseif ($employee->status == 'Terminated')
                            <span class="status-terminated">{{ $employee->status }}</span>
                        @else
                            <span class="status-inactive">{{ $employee->status ?? 'N/A' }}</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Employment Information -->
        <div class="section">
            <h2>Employment Information</h2>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Date of Joining:</strong> {{ $employee->date_of_joining->format('Y-m-d') }}</p>
                    <p><strong>Date of Contract:</strong> {{ $employee->date_of_contract ? $employee->date_of_contract->format('Y-m-d') : 'N/A' }}</p>
                    <p><strong>Date of Termination:</strong> {{ $employee->date_of_termination_of_contract ? $employee->date_of_termination_of_contract->format('Y-m-d') : 'N/A' }}</p>
                    <p><strong>Employee ID:</strong> {{ $employee->employee_id }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>NHIMA ID Number:</strong> {{ $employee->nhima_identification_number ?? 'N/A' }}</p>
                    <p><strong>TPIN Number:</strong> {{ $employee->tpin_number ?? 'N/A' }}</p>
                    <p><strong>NRC/Passport Number:</strong> {{ $employee->nrc_or_passport_number }}</p>
                    <p><strong>Social Security Number:</strong> {{ $employee->social_security_number ?? 'N/A' }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Designation:</strong> {{ $employee->designation }}</p>
                    <p><strong>Department:</strong> {{ $employee->department }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Section:</strong> {{ $employee->section }}</p>
                    <p><strong>Grade:</strong> {{ $employee->grade ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Compensation and Banking Information (Combined for Space) -->
        <div class="section">
            <h2>Compensation and Banking Details</h2>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Basic Salary:</strong> {{ number_format($employee->basic_salary, 2) }} ZMW</p>
                    <p><strong>Housing Allowance:</strong> {{ number_format($employee->housing_allowance, 2) }} ZMW</p>
                    <p><strong>Transport Allowance:</strong> {{ number_format($employee->transport_allowance, 2) }} ZMW</p>
                    <p><strong>Food Allowance:</strong> {{ number_format($employee->food_allowance, 2) }} ZMW</p>
                    <p><strong>Other Allowances:</strong> {{ number_format($employee->other_allowances ?? 0, 2) }} ZMW</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Payment Method:</strong> {{ $employee->payment_method }}</p>
                    <p><strong>Account Name:</strong> {{ $employee->account_name ?? 'N/A' }}</p>
                    <p><strong>Bank Name:</strong> {{ $employee->bank_name ?? 'N/A' }}</p>
                    <p><strong>Branch Name:</strong> {{ $employee->branch_name ?? 'N/A' }}</p>
                    <p><strong>Bank Account Number:</strong> {{ $employee->bank_account_number ?? 'N/A' }}</p>
                    <p><strong>IFSC Code:</strong> {{ $employee->ifsc_code ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
        <div class="section">
            @if ($employee->payslips->isEmpty())
                <p>No payslips available.</p>
            @else
                @php
                    $latestPayslip = $employee->payslips->first();
                @endphp
                <table>
                    <thead>
                        <tr>
                            <th>Gross Earnings</th>
                            <th>Total Deductions</th>
                            <th>Net Pay</th>
                            <th>NAPSA</th>
                            <th>NHIMA</th>
                            <th>Tax (ZRA)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ number_format($latestPayslip->gross_earnings, 2) }} ZMW</td>
                            <td>{{ number_format($latestPayslip->total_deductions, 2) }} ZMW</td>
                            <td>{{ number_format($latestPayslip->net_pay, 2) }} ZMW</td>
                            <td>{{ number_format($latestPayslip->napsa_contribution, 2) }} ZMW</td>
                            <td>{{ number_format($latestPayslip->nhima, 2) }} ZMW</td>
                            <td>{{ number_format($latestPayslip->tax_deduction, 2) }} ZMW</td>
                        </tr>
                    </tbody>
                </table>
            @endif
        </div>

        <!-- References (Limited to First Two) -->
        @if ($employee->references && is_array($employee->references))
            <div class="section">
                <h2>References</h2>
                <div class="row">
                    @foreach ($employee->references as $index => $reference)
                        @if ($index < 2) <!-- Limit to 2 references -->
                            <div class="col-md-6">
                                <p><strong>Name:</strong> {{ $reference['name'] }}</p>
                                <p><strong>Phone Number:</strong> {{ $reference['phone_number'] }}</p>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</body>
</html>
