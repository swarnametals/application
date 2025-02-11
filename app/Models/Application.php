<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model {
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'application_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'nrc_number',
        'position_applied_for',
        'years_of_experience',
        'status',
        'resume_path',
        'cover_letter_path',
        'submitted_at',
    ];

    protected static function boot() {
        parent::boot();

        static::creating(function ($application) {
            if (empty($application->application_id)) {
                $application->application_id = self::generateUniqueApplicationId();
            }
        });
    }

    /**
     * Generate a unique numeric application ID
     */
    private static function generateUniqueApplicationId()
    {
        do {
            $id = mt_rand(1000000000, 9999999999); // Generate a 10-digit number
        } while (self::where('application_id', $id)->exists());

        return $id;
    }

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
}
