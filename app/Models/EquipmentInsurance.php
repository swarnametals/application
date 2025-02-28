<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentInsurance extends Model {
    use HasFactory;

    protected $fillable = [
        'equipment_id',
        'insurance_company',
        'cost',
        'expiry_date',
    ];

    protected $casts = [
        'cost' => 'decimal:2',
        'expiry_date' => 'date',
    ];

    public function equipment() {
        return $this->belongsTo(Equipment::class);
    }
}
