<?php

namespace App\Repositories;

use App\Interfaces\PlanRepositoryInterface;
use App\Models\Plan;
use Illuminate\Pagination\LengthAwarePaginator;

class PlanRepository implements PlanRepositoryInterface
{
    public function getAllPlans(): LengthAwarePaginator
    {
        return Plan::latest()->paginate(10);
    }

    public function getPlanById($planId): ?Plan
    {
        return Plan::findOrFail($planId);
    }

    public function createPlan(array $planDetails): Plan
    {
        return Plan::create($planDetails);
    }

    public function updatePlan($planId, array $newDetails): bool
    {
        return Plan::whereId($planId)->update($newDetails);
    }

    public function deletePlan($planId): bool
    {
        return Plan::destroy($planId);
    }

    public function getActivePlans(): LengthAwarePaginator
    {
        return Plan::where('is_active', true)->latest()->paginate(10);
    }
}
