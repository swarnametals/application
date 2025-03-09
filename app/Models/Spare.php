<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spare extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'equipment_id',
        'name',
        'price',
        'quantity',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2', // Cast price to decimal with 2 decimal places
        'quantity' => 'decimal:2', // Cast quantity to decimal with 2 decimal places
    ];

    /**
     * Get the equipment that owns the spare part.
     */
    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
}
