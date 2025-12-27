<?php

namespace App\Interfaces;

use App\Models\Member;

interface MemberRepositoryInterface
{
    public function getAllMembers();
    public function getMemberById($memberId);
    public function createMember(array $memberDetails);
    public function updateMember($memberId, array $newDetails);
    public function deleteMember($memberId);
    public function getActiveMembers();
    public function getMembersByTrainer($trainerId);
    public function searchMembers($searchTerm);
}
