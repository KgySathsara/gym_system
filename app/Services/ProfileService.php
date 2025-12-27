<?php

namespace App\Services;

use App\Interfaces\ProfileRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProfileService
{
    protected $profileRepository;

    public function __construct(ProfileRepositoryInterface $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    public function updateProfile(array $data, User $user)
    {
        return $this->profileRepository->updateProfile($data, $user);
    }

    public function updatePassword(array $data, User $user)
    {
        if (!Hash::check($data['current_password'], $user->password)) {
            throw new \Exception('Current password is incorrect.');
        }

        return $this->profileRepository->updatePassword($data, $user);
    }

    public function uploadProfileImage($image, User $user)
    {
        return $this->profileRepository->uploadProfileImage($image, $user);
    }
}
