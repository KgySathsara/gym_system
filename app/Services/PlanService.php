<?php

namespace App\Services;

use App\Interfaces\PlanRepositoryInterface;

class PlanService
{
    public function __construct(
        private PlanRepositoryInterface $planRepository
    ) {}

    public function getAllPlans()
    {
        return $this->planRepository->getAllPlans();
    }

    public function getPlanById($planId)
    {
        return $this->planRepository->getPlanById($planId);
    }

    public function createPlan(array $planDetails)
    {
        // Convert features from string to array if needed
        if (isset($planDetails['features']) && is_string($planDetails['features'])) {
            $planDetails['features'] = $this->convertFeaturesToArray($planDetails['features']);
        }

        return $this->planRepository->createPlan($planDetails);
    }

    public function updatePlan($planId, array $newDetails)
    {
        // Get the current plan to preserve existing values for validation
        $plan = $this->planRepository->getPlanById($planId);

        // If only is_active is being updated, merge with existing data
        if (count($newDetails) === 1 && array_key_exists('is_active', $newDetails)) {
            $newDetails = array_merge([
                'name' => $plan->name,
                'price' => $plan->price,
                'duration_days' => $plan->duration_days,
                'sessions_per_week' => $plan->sessions_per_week,
                'has_trainer' => $plan->has_trainer,
                'description' => $plan->description,
                'features' => $plan->features,
            ], $newDetails);
        } else {
            // Convert features from string to array if needed
            if (array_key_exists('features', $newDetails) && is_string($newDetails['features'])) {
                $newDetails['features'] = $this->convertFeaturesToArray($newDetails['features']);
            }
        }

        return $this->planRepository->updatePlan($planId, $newDetails);
    }

    public function deletePlan($planId)
    {
        return $this->planRepository->deletePlan($planId);
    }

    public function getActivePlans()
    {
        return $this->planRepository->getActivePlans();
    }

    /**
     * Convert features string to array
     */
    private function convertFeaturesToArray(string $features): array
    {
        return array_filter(
            array_map('trim', explode("\n", $features)),
            function($feature) {
                return !empty($feature);
            }
        );
    }
}
