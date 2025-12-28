<?php

namespace App\Services;

use App\Interfaces\TrainerRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;

class TrainerService
{
    public function __construct(
        private TrainerRepositoryInterface $trainerRepository,
        private UserRepositoryInterface $userRepository
    ) {}

    public function getAllTrainers()
    {
        return $this->trainerRepository->getAllTrainers();
    }

    public function getTrainerById($trainerId)
    {
        return $this->trainerRepository->getTrainerById($trainerId);
    }

    public function createTrainer(array $trainerDetails)
    {
        return $this->trainerRepository->createTrainer([
            'user_id' => $trainerDetails['user_id'],
            'specialization' => $trainerDetails['specialization'],
            'experience_years' => $trainerDetails['experience_years'],
            'hourly_rate' => $trainerDetails['hourly_rate'],
            'is_available' => $trainerDetails['is_available'],
        ]);
    }

    public function updateTrainer($trainerId, array $newDetails)
    {
        $trainer = $this->trainerRepository->getTrainerById($trainerId);

        // Update user details if provided
        if (isset($newDetails['name']) || isset($newDetails['email'])) {
            $userDetails = [];
            if (isset($newDetails['name'])) $userDetails['name'] = $newDetails['name'];
            if (isset($newDetails['email'])) $userDetails['email'] = $newDetails['email'];
            if (isset($newDetails['phone'])) $userDetails['phone'] = $newDetails['phone'];
            if (isset($newDetails['address'])) $userDetails['address'] = $newDetails['address'];
            if (isset($newDetails['date_of_birth'])) $userDetails['date_of_birth'] = $newDetails['date_of_birth'];

            $this->userRepository->updateUser($trainer->user_id, $userDetails);
        }

        // Update trainer details - only update provided fields
        $trainerDetails = [];
        $allowedFields = [
            'specialization', 'experience_years', 'certifications', 'bio',
            'hourly_rate', 'is_available', 'working_hours'
        ];

        foreach ($allowedFields as $field) {
            if (array_key_exists($field, $newDetails)) {
                $trainerDetails[$field] = $newDetails[$field];
            }
        }

        if (!empty($trainerDetails)) {
            return $this->trainerRepository->updateTrainer($trainerId, $trainerDetails);
        }

        return true;
    }

    public function deleteTrainer($trainerId)
    {
        $trainer = $this->trainerRepository->getTrainerById($trainerId);
        $this->userRepository->deleteUser($trainer->user_id);
        return $this->trainerRepository->deleteTrainer($trainerId);
    }

    public function getAvailableTrainers()
    {
        return $this->trainerRepository->getAvailableTrainers();
    }

    public function searchTrainers($searchTerm)
    {
        return $this->trainerRepository->searchTrainers($searchTerm);
    }
}
