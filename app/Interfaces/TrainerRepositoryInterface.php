<?php

namespace App\Interfaces;

use App\Models\Trainer;

interface TrainerRepositoryInterface
{
    public function getAllTrainers();
    public function getTrainerById($trainerId);
    public function createTrainer(array $trainerDetails);
    public function updateTrainer($trainerId, array $newDetails);
    public function deleteTrainer($trainerId);
    public function getAvailableTrainers();
    public function searchTrainers($searchTerm);
}
