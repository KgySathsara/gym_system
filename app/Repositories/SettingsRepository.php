<?php

namespace App\Repositories;

use App\Interfaces\SettingsRepositoryInterface;
use App\Models\Setting;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class SettingsRepository implements SettingsRepositoryInterface
{
    protected $settingsCache = [];

    public function updateSettings(array $data)
    {
        foreach ($data as $key => $value) {
            $type = $this->determineType($value);
            $this->setSetting($key, $value, $type);
        }

        // Clear settings cache
        Cache::forget('app_settings');
        $this->settingsCache = []; // Clear local cache

        return true;
    }

    public function getSettings()
    {
        // Try to get from cache first
        return Cache::remember('app_settings', 3600, function () {
            $defaultSettings = $this->getDefaultSettings();
            $dbSettings = $this->getAllSettingsFromDB();

            return array_merge($defaultSettings, $dbSettings);
        });
    }

    public function getSetting($key, $default = null)
    {
        // Check cache first
        if (array_key_exists($key, $this->settingsCache)) {
            return $this->settingsCache[$key];
        }

        $allSettings = $this->getSettings();
        $value = $allSettings[$key] ?? $default;

        // Cache locally
        $this->settingsCache[$key] = $value;

        return $value;
    }

    public function setSetting($key, $value, $type = 'string')
    {
        $setting = Setting::firstOrNew(['key' => $key]);

        $setting->value = $this->formatValueForStorage($value, $type);
        $setting->type = $type;
        $setting->save();

        // Update local cache
        $this->settingsCache[$key] = $value;

        return true;
    }

    public function clearCache()
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');

        // Clear our settings cache
        Cache::forget('app_settings');
        $this->settingsCache = [];

        return 'Cache cleared successfully';
    }

    public function runOptimize()
    {
        Artisan::call('optimize');
        return 'Application optimized successfully';
    }

    public function runMigrations()
    {
        Artisan::call('migrate', ['--force' => true]);
        return 'Database migrations run successfully';
    }

    protected function getAllSettingsFromDB()
    {
        $settings = Setting::all();
        $result = [];

        foreach ($settings as $setting) {
            $result[$setting->key] = $this->castValue($setting->value, $setting->type);
        }

        return $result;
    }

    protected function determineType($value)
    {
        if (is_bool($value)) return 'boolean';
        if (is_int($value)) return 'integer';
        if (is_float($value)) return 'float';
        if (is_array($value)) return 'array';
        if (is_object($value)) return 'object';
        return 'string';
    }

    protected function castValue($value, $type)
    {
        switch ($type) {
            case 'boolean':
            case 'bool':
                return (bool) $value;
            case 'integer':
            case 'int':
                return (int) $value;
            case 'float':
            case 'double':
                return (float) $value;
            case 'array':
                return json_decode($value, true) ?: [];
            case 'object':
                return json_decode($value);
            default:
                return (string) $value;
        }
    }

    protected function formatValueForStorage($value, $type)
    {
        switch ($type) {
            case 'boolean':
                return $value ? '1' : '0';
            case 'array':
            case 'object':
                return json_encode($value);
            default:
                return (string) $value;
        }
    }

    protected function getDefaultSettings()
    {
        return [
            'gym_name' => 'FitLife Pro Gym',
            'gym_address' => '123 Fitness Street, City, State 12345',
            'gym_phone' => '+1 (555) 123-4567',
            'gym_email' => 'info@fitlifepro.com',
            'currency' => 'USD',
            'timezone' => 'UTC',
            'business_hours_start' => '06:00',
            'business_hours_end' => '22:00',
            'max_members_per_trainer' => 20,
            'auto_logout_time' => 60,
            'enable_email_notifications' => true,
            'enable_sms_notifications' => false,
        ];
    }

    public function performMaintenance()
    {
        $results = [];

        $results['cache'] = $this->clearCache();
        $results['optimize'] = $this->runOptimize();
        $results['migrate'] = $this->runMigrations();

        return [
            'status' => true,
            'message' => 'Maintenance tasks executed successfully',
            'details' => $results,
        ];
    }

}
