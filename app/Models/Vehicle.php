<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_number',
        'vehicle_type',
        'driver',
    ];

    public function vehicleLogs() {
        return $this->hasMany(VehicleLog::class);
    }

    public function latestVehicleLog() {
        return $this->hasOne(VehicleLog::class)->latest('departure_date');
    }
}
