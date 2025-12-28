<?php

namespace App\Services;

use App\Interfaces\MemberRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\Member;
use Illuminate\Support\Facades\DB;

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
     * Create MEMBER ONLY (User must already exist)
     */
    public function createMember(array $memberDetails)
    {
        return $this->memberRepository->createMember([
            'user_id' => $memberDetails['user_id'],
            'trainer_id' => $memberDetails['trainer_id'] ?? null,
            'plan_id' => $memberDetails['plan_id'],
            'join_date' => $memberDetails['join_date'],
            'expiry_date' => $memberDetails['expiry_date'],
            'status' => $memberDetails['status'],
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
            $this->userRepository->updateUser($member->user_id, [
                'name' => $newDetails['name'],
                'email' => $newDetails['email'],
                'phone' => $newDetails['phone'] ?? null,
                'address' => $newDetails['address'] ?? null,
                'date_of_birth' => $newDetails['date_of_birth'] ?? null,
            ]);

            // ✅ Update MEMBER data (trainer_id MUST be saved even if null)
            return $this->memberRepository->updateMember($memberId, [
                'trainer_id' => $newDetails['trainer_id'] ?? null, // ✅ FIX
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
