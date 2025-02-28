<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'employee_full_name',
        'phone_number',
        'email',
        'address',
        'nationality',
        'date_of_joining',
        'employee_id',
        'tpin_number',
        'nrc_or_passport_number',
        'designation',
        'department',
        'grade',
        'basic_salary',
        'housing_allowance',
        'transport_allowance',
        'other_allowances',
        'food_allowance',
        'references',
        'payment_method',
        'social_security_number',
        'account_name',
        'ifsc_code',
        'bank_name',
        'branch_name',
        'bank_address',
        'bank_telephone_number',
        'bank_account_number',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'basic_salary' => 'decimal:2',
        'housing_allowance' => 'decimal:2',
        'transport_allowance' => 'decimal:2',
        'other_allowances' => 'decimal:2',
        'food_allowance' => 'decimal:2',
        'references' => 'array', // Cast JSON field to array
    ];

    public function payslips()
    {
        return $this->hasMany(Payslip::class, 'employee_id');
    }

    public function overtimes()
    {
        return $this->hasMany(Overtime::class, 'employee_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tripsAsDriver()
    {
        return $this->hasMany(Trip::class, 'driver_id');
    }

    public function machineryUsagesAsOperator()
    {
        return $this->hasMany(MachineryUsage::class, 'operator_id');
    }
}
