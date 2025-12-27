<?php

namespace App\Repositories;

use App\Interfaces\MemberRepositoryInterface;
use App\Models\Member;
use Illuminate\Pagination\LengthAwarePaginator;

class MemberRepository implements MemberRepositoryInterface
{
    public function getAllMembers(): LengthAwarePaginator
    {
        return Member::with(['user', 'trainer.user', 'plan'])
            ->latest()
            ->paginate(10);
    }

    public function getMemberById($memberId): ?Member
    {
        return Member::with(['user', 'trainer.user', 'plan', 'payments', 'attendances'])
            ->findOrFail($memberId);
    }

    public function createMember(array $memberDetails): Member
    {
        return Member::create($memberDetails);
    }

    public function updateMember($memberId, array $newDetails): bool
    {
        return Member::whereId($memberId)->update($newDetails);
    }

    public function deleteMember($memberId): bool
    {
        return Member::destroy($memberId);
    }

    public function getActiveMembers(): LengthAwarePaginator
    {
        return Member::with(['user', 'plan'])
            ->where('status', 'active')
            ->where('expiry_date', '>=', now())
            ->latest()
            ->paginate(10);
    }

    public function getMembersByTrainer($trainerId): LengthAwarePaginator
    {
        return Member::with(['user', 'plan'])
            ->where('trainer_id', $trainerId)
            ->latest()
            ->paginate(10);
    }

    public function searchMembers($searchTerm): LengthAwarePaginator
    {
        return Member::with(['user', 'trainer.user', 'plan'])
            ->whereHas('user', function($query) use ($searchTerm) {
                $query->where('name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('email', 'LIKE', "%{$searchTerm}%");
            })
            ->latest()
            ->paginate(10);
    }
}
