<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository implements UserRepositoryInterface
{
    public function getAllUsers(): LengthAwarePaginator
    {
        return User::with(['member', 'trainer'])->latest()->paginate(10);
    }

    public function getUserById($userId): ?User
    {
        return User::with(['member', 'trainer'])->findOrFail($userId);
    }

    public function createUser(array $userDetails): User
    {
        return User::create($userDetails);
    }

    public function updateUser($userId, array $newDetails): bool
    {
        return User::whereId($userId)->update($newDetails);
    }

    public function deleteUser($userId): bool
    {
        return User::destroy($userId);
    }

    public function getUserByEmail($email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function getUsersByRole($role): LengthAwarePaginator
    {
        return User::where('role', $role)->latest()->paginate(10);
    }
}
