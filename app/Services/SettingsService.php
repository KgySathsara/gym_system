<?php

namespace App\Services;

use App\Interfaces\SettingsRepositoryInterface;
use Illuminate\Support\Facades\Log;

class SettingsService
{
    protected $settingsRepository;

    public function __construct(SettingsRepositoryInterface $settingsRepository)
    {
        $this->settingsRepository = $settingsRepository;
    }

    public function updateSettings(array $data)
    {
        try {
            Log::info('SettingsService: Updating settings', $data);
            $result = $this->settingsRepository->updateSettings($data);
            Log::info('SettingsService: Update result', ['result' => $result]);
            return $result;
        } catch (\Exception $e) {
            Log::error('SettingsService error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getSettings()
    {
        return $this->settingsRepository->getSettings();
    }

    public function performMaintenance($action)
    {
        return $this->settingsRepository->performMaintenance($action);
    }
}
