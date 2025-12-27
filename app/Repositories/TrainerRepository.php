<?php

namespace App\Repositories;

use App\Interfaces\TrainerRepositoryInterface;
use App\Models\Trainer;
use Illuminate\Pagination\LengthAwarePaginator;

class TrainerRepository implements TrainerRepositoryInterface
{
    public function getAllTrainers(): LengthAwarePaginator
    {
        return Trainer::with(['user', 'members.user'])
            ->latest()
            ->paginate(10);
    }

    public function getTrainerById($trainerId): ?Trainer
    {
        return Trainer::with(['user', 'members.user', 'workoutPlans.member.user'])
            ->findOrFail($trainerId);
    }

    public function createTrainer(array $trainerDetails): Trainer
    {
        return Trainer::create($trainerDetails);
    }

    public function updateTrainer($trainerId, array $newDetails): bool
    {
        return Trainer::whereId($trainerId)->update($newDetails);
    }

    public function deleteTrainer($trainerId): bool
    {
        return Trainer::destroy($trainerId);
    }

    public function getAvailableTrainers(): LengthAwarePaginator
    {
        return Trainer::with(['user'])
            ->where('is_available', true)
            ->latest()
            ->paginate(10);
    }

    public function searchTrainers($searchTerm): LengthAwarePaginator
    {
        return Trainer::with(['user'])
            ->whereHas('user', function($query) use ($searchTerm) {
                $query->where('name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('email', 'LIKE', "%{$searchTerm}%");
            })
            ->orWhere('specialization', 'LIKE', "%{$searchTerm}%")
            ->latest()
            ->paginate(10);
    }
}
