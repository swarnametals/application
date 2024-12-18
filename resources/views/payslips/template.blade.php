<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Payslip</title>
<style>
    body {
        font-family: sans-serif;
        background-image: url('{{ public_path('images/logo_circle.jpg') }}');
        background-repeat: no-repeat;
        background-position: center;
        background-size: 500px;
        opacity: 1;
    }

    .payslip {
        padding: 10px;
        margin: 10px auto;
        max-width: 700px;
        background: rgba(255, 255, 255, 0.78); /* Add a white background for readability */
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .center-text {
        text-align: center;
    }

    .logo {
        display: block;
        margin: 0 auto 10px;
        max-width: 80px;
        height: auto;
    }

    .company-header {
        text-align: center;
        margin-bottom: 15px;
    }

    .company-header h1 {
        margin: 0;
        color: #510404;
        font-size: 30px;
        font-weight: bold;
    }

    .payslip table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 10px;
    }

    .payslip th, .payslip td {
        padding: 4px;
        border: 1px solid #000000;
        font-size: 12px;
        text-align: left;
    }

    .payslip .bold {
        font-weight: bold;
    }

    .payslip .right {
        text-align: right;
    }

    .payslip p {
        font-size: 11px;
    }

    .payslip h4 {
        margin-bottom: 0px;
    }
</style>

</head>
<body>
    <div class="payslip">
        <div class="center-text">
            <img src="{{ public_path('images/logo_circle.jpg') }}" alt="Swarna Metals Logo" class="logo">
        </div>

        <div class="company-header">
            <h1>SWARNA METALS ZAMBIA LIMITED</h1>
        </div>

        <div class="title">
            <h4><strong>Pay Slip</strong></h4>
        </div>
        <table>
            <tr>
                <th>Employee Name:</th>
                <td>{{ $employee->name }}</td>
                <th>Employee ID:</th>
                <td>{{ $employee->id_number }}</td>
            </tr>
            <tr>
                <th>Designation:</th>
                <td>{{ $employee->position }}</td>
                <th>Grade:</th>
                <td>{{ $employee->grade }}</td>
            </tr>
            <tr>
                <th>Department/Team:</th>
                <td colspan="3">{{ $employee->team }}</td>
            </tr>
        </table>

        <h4>Year-to-Date Summary</h4>
        <table>
            <tr>
                <th>Gross Pay YTD:</th>
                <td>{{ number_format($payslipData['gross_pay_ytd'], 2) }} ZMW</td>
                <th>Tax (ZRA) Paid YTD:</th>
                <td>{{ number_format($payslipData['tax_paid_ytd'], 2) }} ZMW</td>
            </tr>
            <tr>
                <th>NAPSA Contribution YTD:</th>
                <td>{{ number_format($payslipData['napsa_ytd'], 2) }} ZMW</td>
                <th>Pension Contribution YTD:</th>
                <td>{{ number_format($payslipData['pension_ytd'], 2) }} ZMW</td>
            </tr>
            <tr>
                <th>Leave Balance (Days):</th>
                <td>-</td>
                <td colspan="2"></td>
            </tr>
        </table>

        <!-- Earnings -->
        <h4>Earnings</h4>
        <table>
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Shift/Hrs</th>
                    <th>Amount (ZMW)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>E01</td>
                    <td>Basic Pay</td>
                    <td></td>
                    <td>{{ $employee->basic_salary }}</td>
                </tr>
                <tr>
                    <td>E02</td>
                    <td>Housing Allowance</td>
                    <td></td>
                    <td>{{ number_format($payslipData['housing_allowance'], 2) }}</td>
                </tr>
                <tr>
                    <td>E03</td>
                    <td>Lunch Allowance</td>
                    <td></td>
                    <td>{{ number_format($payslipData['lunch_allowance'], 2) }}</td>
                </tr>
                <tr>
                    <td>E04</td>
                    <td>Transport Allowance</td>
                    <td></td>
                    <td>{{ number_format($payslipData['transport_allowance'], 2) }}</td>
                </tr>
                <tr>
                    <td>E05</td>
                    <td>Overtime Pay</td>
                    <td>{{ number_format($payslipData['overtime_hours'], 2) }}</td>
                    <td>{{ number_format($payslipData['overtime_pay'], 2) }}</td>
                </tr>
                <tr>
                    <td>E06</td>
                    <td>Other Allowances</td>
                    <td></td>
                    <td>{{ number_format($payslipData['other_allowances'], 2) }}</td>
                </tr>
                <tr>
                    <th colspan="3">Total Earnings</th>
                    <th>{{ number_format($payslipData['total_earnings'], 2) }}</th>
                </tr>
            </tbody>
        </table>

        <h4>Deductions</h4>
        <table>
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Amount (ZMW)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>D01</td>
                    <td>NAPSA Contribution</td>
                    <td>{{ number_format($payslipData['napsa'], 2) }}</td>
                </tr>
                <tr>
                    <td>D02</td>
                    <td>Health Insurance (NHIMA)</td>
                    <td>{{ number_format($payslipData['health_insurance'], 2) }}</td>
                </tr>
                <tr>
                    <td>D03</td>
                    <td>Loan Recovery</td>
                    <td>{{ number_format($payslipData['loan_recovery'], 2) }}</td>
                </tr>
                <tr>
                    <td>D04</td>
                    <td>Other Deductions</td>
                    <td>{{ number_format($payslipData['other_deductions'], 2) }}</td>
                </tr>
                <tr>
                    <td>D05</td>
                    <td>Tax Deduction (ZRA)</td>
                    <td>{{ number_format($payslipData['tax_paid_ytd'], 2) }}</td>
                </tr>
                <tr>
                    <th colspan="2">Total Deductions</th>
                    <th>{{ number_format($payslipData['total_deductions'], 2) }}</th>
                </tr>
            </tbody>
        </table>

        <p><strong>Net Pay:</strong> {{ number_format($payslipData['net_pay'], 2) }} ZMW</p>
        <p><strong>Payment Method:</strong> {{ $employee->payment_method }}</p>

        <h4>Additional Information</h4>
        <p style="display: inline-block; margin-right: 20px;">
            <strong>Social Security Number:</strong> {{ $employee->social_security_number }}
        </p>
        <p style="display: inline-block;">
            <strong>Bank Name:</strong> {{ $employee->bank_name }}
        </p>
        <p style="display: inline-block; margin-right: 20px;">
            <strong>Branch Name:</strong> {{ $employee->branch_name }}
        </p>
        <p style="display: inline-block;">
            <strong>Bank Account Number:</strong> {{ $employee->bank_account_number }}
        </p>
        <p><strong>Prepared By:</strong>............................................................................................................................   <strong>Date:</strong>.............................................</p>
    </div>
</body>
</html>
