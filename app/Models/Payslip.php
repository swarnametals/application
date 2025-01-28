<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payslip extends Model {
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'employee_id',
        'gross_earnings',
        'days_worked',
        'total_deductions',
        'net_pay',
        'napsa_contribution',
        'nhima',
        'tax_deduction',
    ];

    public function employee() {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
