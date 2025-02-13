<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuelLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_log_id',
        'litres_added',
        'refuel_location',
    ];

    public function vehicleLog()
    {
        return $this->belongsTo(VehicleLog::class);
    }
}
