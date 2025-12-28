<?php

namespace App\Interfaces;

interface SettingsRepositoryInterface
{
    public function updateSettings(array $data);
    public function getSettings();
    public function clearCache();
    public function runOptimize();
    public function runMigrations();

    // ✅ ADD THIS
    public function performMaintenance();
}
