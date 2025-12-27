<?php

namespace App\Services;

use App\Interfaces\MemberRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\Member;

class MemberService
{
    public function __construct(
        private MemberRepositoryInterface $memberRepository,
        private UserRepositoryInterface $userRepository
    ) {}

    public function getAllMembers()
    {
        return $this->memberRepository->getAllMembers();
    }

    public function getMemberById($memberId)
    {
        return $this->memberRepository->getMemberById($memberId);
    }

    public function createMember(array $memberDetails)
    {
        // First create user
        $user = $this->userRepository->createUser([
            'name' => $memberDetails['name'],
            'email' => $memberDetails['email'],
            'password' => $memberDetails['password'],
            'role' => 'member',
            'phone' => $memberDetails['phone'],
            'address' => $memberDetails['address'],
            'date_of_birth' => $memberDetails['date_of_birth'],
        ]);

        // Then create member
        return $this->memberRepository->createMember([
            'user_id' => $user->id,
            'trainer_id' => $memberDetails['trainer_id'],
            'plan_id' => $memberDetails['plan_id'],
            'join_date' => $memberDetails['join_date'],
            'expiry_date' => $memberDetails['expiry_date'],
            'status' => $memberDetails['status'],
            'height' => $memberDetails['height'],
            'weight' => $memberDetails['weight'],
            'medical_conditions' => $memberDetails['medical_conditions'],
            'fitness_goals' => $memberDetails['fitness_goals'],
        ]);
    }

    public function updateMember($memberId, array $newDetails)
    {
        $member = $this->memberRepository->getMemberById($memberId);

        // Update user details if provided
        if (isset($newDetails['name']) || isset($newDetails['email'])) {
            $userDetails = [];
            if (isset($newDetails['name'])) $userDetails['name'] = $newDetails['name'];
            if (isset($newDetails['email'])) $userDetails['email'] = $newDetails['email'];
            if (isset($newDetails['phone'])) $userDetails['phone'] = $newDetails['phone'];
            if (isset($newDetails['address'])) $userDetails['address'] = $newDetails['address'];
            if (isset($newDetails['date_of_birth'])) $userDetails['date_of_birth'] = $newDetails['date_of_birth'];

            $this->userRepository->updateUser($member->user_id, $userDetails);
        }

        // Update member details
        $memberDetails = array_filter($newDetails, function($key) {
            return in_array($key, [
                'trainer_id', 'plan_id', 'join_date', 'expiry_date', 'status',
                'height', 'weight', 'medical_conditions', 'fitness_goals'
            ]);
        }, ARRAY_FILTER_USE_KEY);

        return $this->memberRepository->updateMember($memberId, $memberDetails);
    }

    public function deleteMember($memberId)
    {
        $member = $this->memberRepository->getMemberById($memberId);
        $this->userRepository->deleteUser($member->user_id);
        return $this->memberRepository->deleteMember($memberId);
    }

    public function getActiveMembers()
    {
        return $this->memberRepository->getActiveMembers();
    }

    public function searchMembers($searchTerm)
    {
        return $this->memberRepository->searchMembers($searchTerm);
    }
}
