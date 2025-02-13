<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id',
        'departure_date',
        'return_date',
        'start_kilometers',
        'end_kilometers',
        'material_delivered',
        'location',
        'quantity',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function fuelLogs()
    {
        return $this->hasMany(FuelLog::class);
    }

    public function getDistanceTravelledAttribute()
    {
        return $this->end_kilometers ? $this->end_kilometers - $this->start_kilometers : 0;
    }
}

