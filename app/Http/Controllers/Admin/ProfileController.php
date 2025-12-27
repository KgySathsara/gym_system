<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Services\ProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(UpdateProfileRequest $request)
    {
        try {
            $user = Auth::user();
            $data = $request->validated();

            // Handle password change separately
            if ($request->filled('current_password')) {
                $this->profileService->updatePassword($data, $user);
                unset($data['current_password'], $data['new_password'], $data['new_password_confirmation']);
            }

            // Update profile data
            if (!empty($data)) {
                $this->profileService->updateProfile($data, $user);
            }

            return redirect()->route('profile.edit')->with('success', 'Profile updated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }
}
