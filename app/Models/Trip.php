<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model {
    use HasFactory;

    protected $fillable = [
        'equipment_id',
        'driver_id',
        'trip_number',
        'departure_date',
        'return_date',
        'start_kilometers',
        'end_kilometers',
        'material_delivered',
        'location',
        'quantity',
    ];

    protected $casts = [
        'departure_date' => 'date',
        'return_date' => 'date',
        'quantity' => 'decimal:2', // Casting to decimal with 2 decimal places
    ];

    public function equipment() {
        return $this->belongsTo(Equipment::class);
    }

    public function driver() {
        return $this->belongsTo(Employee::class, 'driver_id');
    }

    public function fuels() {
        return $this->hasMany(Fuel::class);
    }
}
