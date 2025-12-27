<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkoutPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'trainer_id',
        'title',
        'description',
        'difficulty',
        'duration_weeks',
        'weekly_schedule',
        'exercises',
        'diet_plan',
        'notes',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'weekly_schedule' => 'array',
            'exercises' => 'array',
            'start_date' => 'date',
            'end_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }
}
