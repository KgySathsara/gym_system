<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'duration_days',
        'sessions_per_week',
        'has_trainer',
        'is_active',
        'features',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'has_trainer' => 'boolean',
        'is_active' => 'boolean',
        'features' => 'array', // This automatically handles JSON encoding/decoding
    ];

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
