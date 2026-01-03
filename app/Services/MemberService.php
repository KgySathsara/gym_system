<?php

namespace App\Services;

use App\Interfaces\MemberRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class MemberService
{
    public function __construct(
        private MemberRepositoryInterface $memberRepository,
        private UserRepositoryInterface $userRepository
    ) {}

    /**
     * Get all members (paginated)
     */
    public function getAllMembers()
    {
        return $this->memberRepository->getAllMembers();
    }

    /**
     * Get single member by ID
     */
    public function getMemberById($memberId): ?Member
    {
        return $this->memberRepository->getMemberById($memberId);
    }

    /**
     * Create new member with user
     */
    public function createMember(array $memberDetails): Member
    {
        return DB::transaction(function () use ($memberDetails) {
            // Create user first
            $user = User::create([
                'name' => $memberDetails['name'],
                'email' => $memberDetails['email'],
                'password' => Hash::make($memberDetails['password']),
                'phone' => $memberDetails['phone'] ?? null,
                'address' => $memberDetails['address'] ?? null,
                'date_of_birth' => $memberDetails['date_of_birth'] ?? null,
                'profile_image' => $memberDetails['profile_image'] ?? null,
            ]);

            // Create member record
            return $this->memberRepository->createMember([
                'user_id' => $user->id,
                'trainer_id' => $memberDetails['trainer_id'] ?? null,
                'plan_id' => $memberDetails['plan_id'],
                'join_date' => $memberDetails['join_date'],
                'expiry_date' => $memberDetails['expiry_date'],
                'status' => $memberDetails['status'],
                'height' => $memberDetails['height'] ?? null,
                'weight' => $memberDetails['weight'] ?? null,
                'medical_conditions' => $memberDetails['medical_conditions'] ?? null,
                'fitness_goals' => $memberDetails['fitness_goals'] ?? null,
            ]);
        });
    }

    public function uploadProfileImage($image)
    {
        $fileName = time().'_'.Str::random(20).'.'.$image->getClientOriginalExtension();

        $image->storeAs('profiles', $fileName, 'public');

        return $fileName;
    }

    public function updateMemberPhoto(int $memberId, $image): void
    {
        $member = $this->memberRepository->getMemberById($memberId);
        $user = $member->user;

        // Delete old image
        if ($user->profile_image) {
            Storage::disk('public')->delete('profiles/' . $user->profile_image);
        }

        $fileName = time() . '_' . Str::random(20) . '.' . $image->getClientOriginalExtension();

        $image->storeAs('profiles', $fileName, 'public');

        $user->update([
            'profile_image' => $fileName,
        ]);
    }

    /**
     * Update member + user basic info
     */
    public function updateMember($memberId, array $newDetails): bool
    {
        return DB::transaction(function () use ($memberId, $newDetails) {
            $member = $this->memberRepository->getMemberById($memberId);

            // Update USER data
            $userData = [
                'name' => $newDetails['name'],
                'email' => $newDetails['email'],
                'phone' => $newDetails['phone'] ?? null,
                'address' => $newDetails['address'] ?? null,
                'date_of_birth' => $newDetails['date_of_birth'] ?? null,
            ];

            // Update password if provided
            if (!empty($newDetails['password'])) {
                $userData['password'] = Hash::make($newDetails['password']);
            }

            $this->userRepository->updateUser($member->user_id, $userData);

            // Update MEMBER data
            return $this->memberRepository->updateMember($memberId, [
                'trainer_id' => $newDetails['trainer_id'] ?? null,
                'plan_id' => $newDetails['plan_id'],
                'join_date' => $newDetails['join_date'],
                'expiry_date' => $newDetails['expiry_date'],
                'status' => $newDetails['status'],
                'height' => $newDetails['height'] ?? null,
                'weight' => $newDetails['weight'] ?? null,
                'medical_conditions' => $newDetails['medical_conditions'] ?? null,
                'fitness_goals' => $newDetails['fitness_goals'] ?? null,
            ]);
        });
    }

    /**
     * Delete member + user
     */
    public function deleteMember($memberId): bool
    {
        return DB::transaction(function () use ($memberId) {
            $member = $this->memberRepository->getMemberById($memberId);

            // Delete profile image if exists
            if ($member->user->profile_image) {
                Storage::disk('public')->delete('profiles/' . $member->user->profile_image);
            }

            $this->memberRepository->deleteMember($memberId);
            $this->userRepository->deleteUser($member->user_id);

            return true;
        });
    }

    /**
     * Get active members
     */
    public function getActiveMembers()
    {
        return $this->memberRepository->getActiveMembers();
    }

    /**
     * Search members
     */
    public function searchMembers(string $searchTerm)
    {
        return $this->memberRepository->searchMembers($searchTerm);
    }
}
