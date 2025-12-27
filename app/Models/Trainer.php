<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'specialization',
        'experience_years',
        'certifications',
        'bio',
        'hourly_rate',
        'is_available',
        'working_hours',
    ];

    protected function casts(): array
    {
        return [
            'hourly_rate' => 'decimal:2',
            'is_available' => 'boolean',
            'working_hours' => 'array',
            'certifications' => 'array',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function workoutPlans()
    {
        return $this->hasMany(WorkoutPlan::class);
    }
}
