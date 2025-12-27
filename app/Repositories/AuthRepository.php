<?php

namespace App\Repositories;

use App\Interfaces\AuthRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthRepository implements AuthRepositoryInterface
{
    public function register(array $userDetails): User
    {
        return User::create([
            'name' => $userDetails['name'],
            'email' => $userDetails['email'],
            'password' => Hash::make($userDetails['password']),
            'role' => $userDetails['role'] ?? 'member',
            'phone' => $userDetails['phone'] ?? null,
            'address' => $userDetails['address'] ?? null,
            'date_of_birth' => $userDetails['date_of_birth'] ?? null,
        ]);
    }

    public function login(array $credentials): bool
    {
        return Auth::attempt($credentials);
    }

    public function logout(): void
    {
        Auth::logout();
    }

    public function getUser(): ?User
    {
        return Auth::user();
    }
}
