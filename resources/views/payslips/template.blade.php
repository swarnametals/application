<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Payslip</title>
    <style>
        @page {
            size: landscape;
            margin: 10px;
        }

        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
             background-image: url('{{ public_path('images/logo_circle.jpg') }}');
            background-repeat: no-repeat;
            background-position: center;
            background-size: 500px;
            opacity: 1;
        }

        .payslip-left {
            width: 47%;
            border: 1px solid #000;
            padding: 10px;
            box-sizing: border-box;
            float: left;
            background: rgba(255, 255, 255, 0.78);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .payslip-right {
            width: 47%;
            border: 1px solid #000;
            padding: 10px;
            box-sizing: border-box;
            float: right;
            background: rgba(255, 255, 255, 0.78);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .center-text {
            text-align: center;
        }

        .logo {
            display: block;
            margin: 0 auto 10px;
            max-width: 60px;
            height: auto;
        }

        .company-header {
            text-align: center;
            margin-bottom: 5px;
        }

        .company-header h1 {
            margin: 0;
            font-size: 17px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }

        th, td {
            border: 1px solid #000;
            padding: 2px;
            font-size: 12px;
        }

        th {
            text-align: left;
        }

        h4 {
            margin: 2px 0;
            font-size: 12px;
        }

         p {
            margin: 1px 0;
            font-size: 12px;
        }

        .qr-code {
            text-align: left;
            margin-top: 2px;
        }

        .qr-code img {
            width: 40px;
            height: 40px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Payslip Copy 1 -->
        <div class="payslip-left">
            <div class="center-text">
                <img src="{{ public_path('images/logo_circle.jpg') }}" alt="QR Code" class="logo">
            </div>

            <div class="company-header">
                <h1>SWARNA METALS ZAMBIA LIMITED</h1>
            </div>

            <h4>Pay Slip</h4>
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
                    <th>Department:</th>
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
            <p><strong>Prepared By:</strong>........................................................................ <strong>Date:</strong>.................................................</p>
            <div class="qr-code">
                <img src="{{ public_path('images/qr-code-swarna.png') }}" alt="QR Code">
                <p style="font-size:10px; float:right;">Mobile: +26 077 510 9221 Office: Flat #J5, ZSIC Flats, Thorn Park, Off Great East Road,Lusaka <br> Email: hr@plrprojects.com  Farm Sub-A of 4213, Sabina-Mufilira Road,Kitwe</p>
            </div>
        </div>

        <!-- Payslip Copy 2 -->
        <div class="payslip-right">
            <div class="center-text">
                <img src="{{ public_path('images/logo_circle.jpg') }}" alt="QR Code" class="logo">
            </div>

            <div class="company-header">
                <h1>SWARNA METALS ZAMBIA LIMITED</h1>
            </div>

            <h4>Pay Slip</h4>
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
                    <th>Department:</th>
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
            <p><strong>Prepared By:</strong>........................................................................ <strong>Date:</strong>.................................................</p>
            <div class="qr-code">
                <img src="{{ public_path('images/qr-code-swarna.png') }}" alt="QR Code">
                <p style="font-size:10px; float:right;">Mobile: +26 077 510 9221 Office: Flat #J5, ZSIC Flats, Thorn Park, Off Great East Road,Lusaka <br> Email: hr@plrprojects.com  Farm Sub-A of 4213, Sabina-Mufilira Road,Kitwe</p>
            </div>
        </div>
    </div>
</body>
</html>
