<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model {
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name',
        'id_number',
        'position',
        'grade',
        'team',
        'basic_salary',
        'housing_allowance',
        'transport_allowance',
        'other_allowances',
        'lunch_allowance',
        'loan_recovery',
        'other_deductions',
        'overtime_hours',
        'overtime_pay',
        'payment_method',
        'social_security_number',
        'bank_account_number',
        'bank_name',
        'branch_name',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'basic_salary' => 'float',
        'housing_allowance' => 'float',
        'transport_allowance' => 'float',
        'other_allowances' => 'float',
        'lunch_allowance' => 'float',
        'overtime_hours' => 'float',
        'overtime_pay' => 'float',
        'loan_recovery' => 'float',
        'other_deductions' => 'float',
    ];

    public function payslips() {
        return $this->hasMany(Payslip::class, 'employee_id');
    }

    public function overtimes() {
        return $this->hasMany(Overtime::class, 'employee_id');
    }
}
