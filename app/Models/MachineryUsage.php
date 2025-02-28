<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineryUsage extends Model {
    use HasFactory;

    protected $fillable = [
        'equipment_id',
        'operator_id',
        'date',
        'start_hours',
        'closing_hours',
        'location',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function equipment() {
        return $this->belongsTo(Equipment::class);
    }

    public function operator() {
        return $this->belongsTo(Employee::class, 'operator_id');
    }

    public function fuels() {
        return $this->hasMany(Fuel::class);
    }
}
