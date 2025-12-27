<?php

namespace App\Interfaces;

use App\Models\Plan;

interface PlanRepositoryInterface
{
    public function getAllPlans();
    public function getPlanById($planId);
    public function createPlan(array $planDetails);
    public function updatePlan($planId, array $newDetails);
    public function deletePlan($planId);
    public function getActivePlans();
}
