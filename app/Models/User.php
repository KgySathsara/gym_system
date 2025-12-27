<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'date_of_birth',
        'profile_image',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'date',
        ];
    }

    public function member()
    {
        return $this->hasOne(Member::class);
    }

    public function trainer()
    {
        return $this->hasOne(Trainer::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isTrainer()
    {
        return $this->role === 'trainer';
    }

    public function isMember()
    {
        return $this->role === 'member';
    }
}
