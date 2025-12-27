<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'trainer_id',
        'plan_id',
        'join_date',
        'expiry_date',
        'status',
        'height',
        'weight',
        'medical_conditions',
        'fitness_goals',
    ];

    protected function casts(): array
    {
        return [
            'join_date' => 'date',
            'expiry_date' => 'date',
            'height' => 'decimal:2',
            'weight' => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function workoutPlans()
    {
        return $this->hasMany(WorkoutPlan::class);
    }

    public function getIsActiveAttribute()
    {
        return $this->status === 'active' && $this->expiry_date >= now();
    }
}
