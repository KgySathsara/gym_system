<?php

namespace App\Repositories;

use App\Interfaces\ProfileRepositoryInterface;
use App\Models\User;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileRepository implements ProfileRepositoryInterface
{
    use FileUploadTrait;

    public function updateProfile(array $data, User $user)
    {
        if (isset($data['profile_image'])) {
            $data['profile_image'] = $this->uploadProfileImage($data['profile_image'], $user);
        }

        return $user->update($data);
    }

    public function updatePassword(array $data, User $user)
    {
        return $user->update([
            'password' => Hash::make($data['new_password'])
        ]);
    }

    public function uploadProfileImage($image, User $user)
    {
        // Delete old image if exists
        if ($user->profile_image) {
            Storage::delete('public/profiles/' . $user->profile_image);
        }

        $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public/profiles', $imageName);

        return $imageName;
    }
}
