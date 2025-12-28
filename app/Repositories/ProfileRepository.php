<?php

namespace App\Repositories;

use App\Interfaces\ProfileRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileRepository implements ProfileRepositoryInterface
{
    public function updateProfile(array $data, User $user)
    {
        // Handle image upload
        if (isset($data['profile_image'])) {
            $data['profile_image'] = $this->uploadProfileImage($data['profile_image'], $user);
        }

        $user->update($data);
        return $user;
    }

    public function updatePassword(array $data, User $user)
    {
        $user->update([
            'password' => bcrypt($data['new_password']),
        ]);

        return $user;
    }

    public function uploadProfileImage($image, User $user)
    {
        // Delete old image
        if ($user->profile_image && Storage::disk('public')->exists('profiles/' . $user->profile_image)) {
            Storage::disk('public')->delete('profiles/' . $user->profile_image);
        }

        $fileName = time() . '_' . Str::random(20) . '.' . $image->getClientOriginalExtension();

        $image->storeAs('profiles', $fileName, 'public');

        return $fileName;
    }
}
