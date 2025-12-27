<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\UpdateSettingsRequest;
use App\Services\SettingsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SettingsController extends Controller
{
    protected $settingsService;

    public function __construct(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    public function edit()
    {
        try {
            $settings = $this->settingsService->getSettings();

            // Debug information
            $debug = [
                'settings_loaded' => !empty($settings),
                'settings_count' => count($settings),
                'sample_settings' => array_slice($settings, 0, 3) // Show first 3 settings
            ];

            return view('settings.edit', compact('settings', 'debug'));

        } catch (\Exception $e) {
            Log::error('Settings edit error: ' . $e->getMessage());
            return redirect()->route('dashboard')->with('error', 'Unable to load settings.');
        }
    }

    public function update(Request $request) // Temporarily remove validation for testing
    {
        try {
            // Log the incoming request
            Log::info('Settings update request:', $request->all());

            // Simple validation
            $validated = $request->validate([
                'gym_name' => 'required|string|max:255',
                'currency' => 'required|string|max:10',
                'gym_phone' => 'nullable|string|max:20',
                'enable_email_notifications' => 'nullable|boolean',
            ]);

            // Prepare data for service
            $data = [
                'gym_name' => $validated['gym_name'],
                'currency' => $validated['currency'],
                'gym_phone' => $validated['gym_phone'] ?? '',
                'enable_email_notifications' => $request->has('enable_email_notifications'),
            ];

            Log::info('Processed data for update:', $data);

            // Update settings
            $result = $this->settingsService->updateSettings($data);

            Log::info('Settings update result: ' . ($result ? 'success' : 'failed'));

            return redirect()->route('settings.edit')->with('success', 'Settings updated successfully!');

        } catch (\Exception $e) {
            Log::error('Settings update error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update settings: ' . $e->getMessage())->withInput();
        }
    }

    public function maintenance(Request $request)
    {
        $request->validate([
            'action' => 'required|in:clear_cache,optimize,migrate'
        ]);

        try {
            $message = $this->settingsService->performMaintenance($request->action);
            return redirect()->route('settings.edit')->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Maintenance action failed: ' . $e->getMessage());
        }
    }
}
