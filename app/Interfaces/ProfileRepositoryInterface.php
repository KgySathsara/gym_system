<?php

namespace App\Interfaces;

use App\Models\User;

interface ProfileRepositoryInterface
{
    public function updateProfile(array $data, User $user);
    public function updatePassword(array $data, User $user);
    public function uploadProfileImage($image, User $user);
}
