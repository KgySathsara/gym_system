<?php

namespace App\Interfaces;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    public function getAllUsers(): LengthAwarePaginator;
    public function getUserById($userId): ?User;
    public function createUser(array $userDetails): User;
    public function updateUser($userId, array $newDetails): bool;
    public function deleteUser($userId): bool;
    public function getUserByEmail($email): ?User;
    public function getUsersByRole($role): LengthAwarePaginator;
}
