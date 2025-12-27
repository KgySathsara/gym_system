@extends('layouts.app')

@section('title', 'System Settings')
@section('subtitle', 'Configure your gym management system')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <!-- Settings Navigation -->
            <div class="card">
                <div class="card-body">
                    <div class="nav flex-column nav-pills" id="settingsTabs" role="tablist">
                        <a class="nav-link active" id="general-tab" data-bs-toggle="pill" href="#general" role="tab">
                            <i class="fas fa-cog me-2"></i>General Settings
                        </a>
                        <a class="nav-link" id="business-tab" data-bs-toggle="pill" href="#business" role="tab">
                            <i class="fas fa-building me-2"></i>Business Info
                        </a>
                        <a class="nav-link" id="notifications-tab" data-bs-toggle="pill" href="#notifications" role="tab">
                            <i class="fas fa-bell me-2"></i>Notifications
                        </a>
                        <a class="nav-link" id="maintenance-tab" data-bs-toggle="pill" href="#maintenance" role="tab">
                            <i class="fas fa-tools me-2"></i>System Maintenance
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="tab-content" id="settingsTabsContent">
                <!-- General Settings -->
                <div class="tab-pane fade show active" id="general" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">General Settings</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('settings.update') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="currency" class="form-label">Currency *</label>
                                            <select class="form-control" id="currency" name="currency" required>
                                                <option value="USD" {{ old('currency', $settings['currency']) == 'USD' ? 'selected' : '' }}>USD ($)</option>
                                                <option value="EUR" {{ old('currency', $settings['currency']) == 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                                                <option value="GBP" {{ old('currency', $settings['currency']) == 'GBP' ? 'selected' : '' }}>GBP (£)</option>
                                                <option value="INR" {{ old('currency', $settings['currency']) == 'INR' ? 'selected' : '' }}>INR (₹)</option>
                                                <option value="LKR" {{ old('currency', $settings['currency']) == 'LKR' ? 'selected' : '' }}>LKR (₨)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="timezone" class="form-label">Timezone *</label>
                                            <select class="form-control" id="timezone" name="timezone" required>
                                                <option value="UTC" {{ old('timezone', $settings['timezone']) == 'UTC' ? 'selected' : '' }}>UTC</option>
                                                <option value="America/New_York" {{ old('timezone', $settings['timezone']) == 'America/New_York' ? 'selected' : '' }}>Eastern Time</option>
                                                <option value="America/Chicago" {{ old('timezone', $settings['timezone']) == 'America/Chicago' ? 'selected' : '' }}>Central Time</option>
                                                <option value="America/Denver" {{ old('timezone', $settings['timezone']) == 'America/Denver' ? 'selected' : '' }}>Mountain Time</option>
                                                <option value="America/Los_Angeles" {{ old('timezone', $settings['timezone']) == 'America/Los_Angeles' ? 'selected' : '' }}>Pacific Time</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="auto_logout_time" class="form-label">Auto Logout (minutes)</label>
                                            <input type="number" class="form-control" id="auto_logout_time"
                                                   name="auto_logout_time" min="5" max="480"
                                                   value="{{ old('auto_logout_time', $settings['auto_logout_time']) }}">
                                            <small class="form-text text-muted">Automatic logout after inactivity (5-480 minutes)</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="max_members_per_trainer" class="form-label">Max Members per Trainer</label>
                                            <input type="number" class="form-control" id="max_members_per_trainer"
                                                   name="max_members_per_trainer" min="1"
                                                   value="{{ old('max_members_per_trainer', $settings['max_members_per_trainer']) }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Save General Settings
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Business Information -->
                <div class="tab-pane fade" id="business" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Business Information</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('settings.update') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-group mb-3">
                                    <label for="gym_name" class="form-label">Gym Name *</label>
                                    <input type="text" class="form-control" id="gym_name" name="gym_name"
                                           value="{{ old('gym_name', $settings['gym_name']) }}" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="gym_address" class="form-label">Gym Address *</label>
                                    <textarea class="form-control" id="gym_address" name="gym_address"
                                              rows="3" required>{{ old('gym_address', $settings['gym_address']) }}</textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="gym_phone" class="form-label">Phone Number *</label>
                                            <input type="tel" class="form-control" id="gym_phone" name="gym_phone"
                                                   value="{{ old('gym_phone', $settings['gym_phone']) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="gym_email" class="form-label">Email Address *</label>
                                            <input type="email" class="form-control" id="gym_email" name="gym_email"
                                                   value="{{ old('gym_email', $settings['gym_email']) }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="business_hours_start" class="form-label">Business Hours Start *</label>
                                            <input type="time" class="form-control" id="business_hours_start" name="business_hours_start"
                                                   value="{{ old('business_hours_start', $settings['business_hours_start']) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="business_hours_end" class="form-label">Business Hours End *</label>
                                            <input type="time" class="form-control" id="business_hours_end" name="business_hours_end"
                                                   value="{{ old('business_hours_end', $settings['business_hours_end']) }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Save Business Info
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Notifications Settings -->
                <div class="tab-pane fade" id="notifications" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Notification Settings</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('settings.update') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-group mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="enable_email_notifications"
                                               name="enable_email_notifications" value="1"
                                               {{ old('enable_email_notifications', $settings['enable_email_notifications']) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="enable_email_notifications">
                                            Enable Email Notifications
                                        </label>
                                    </div>
                                    <small class="form-text text-muted">Send email notifications for memberships, payments, and reminders</small>
                                </div>

                                <div class="form-group mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="enable_sms_notifications"
                                               name="enable_sms_notifications" value="1"
                                               {{ old('enable_sms_notifications', $settings['enable_sms_notifications']) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="enable_sms_notifications">
                                            Enable SMS Notifications
                                        </label>
                                    </div>
                                    <small class="form-text text-muted">Send SMS notifications for important alerts (requires SMS gateway setup)</small>
                                </div>

                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Notification Types:</strong> Membership expirations, payment reminders, class cancellations, system alerts
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Save Notification Settings
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- System Maintenance -->
                <div class="tab-pane fade" id="maintenance" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">System Maintenance</h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Warning:</strong> These actions affect system performance and should be performed during low-usage periods.
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card border-primary">
                                        <div class="card-body text-center">
                                            <i class="fas fa-broom fa-3x text-primary mb-3"></i>
                                            <h5>Clear Cache</h5>
                                            <p class="text-muted">Clear application and configuration cache</p>
                                            <form action="{{ route('settings.maintenance') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="action" value="clear_cache">
                                                <button type="submit" class="btn btn-outline-primary btn-sm">
                                                    Run Now
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card border-success">
                                        <div class="card-body text-center">
                                            <i class="fas fa-tachometer-alt fa-3x text-success mb-3"></i>
                                            <h5>Optimize</h5>
                                            <p class="text-muted">Optimize application performance</p>
                                            <form action="{{ route('settings.maintenance') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="action" value="optimize">
                                                <button type="submit" class="btn btn-outline-success btn-sm">
                                                    Run Now
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card border-info">
                                        <div class="card-body text-center">
                                            <i class="fas fa-database fa-3x text-info mb-3"></i>
                                            <h5>Run Migrations</h5>
                                            <p class="text-muted">Update database schema</p>
                                            <form action="{{ route('settings.maintenance') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="action" value="migrate">
                                                <button type="submit" class="btn btn-outline-info btn-sm">
                                                    Run Now
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <h6>System Information</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-sm">
                                            <tr>
                                                <td>Laravel Version:</td>
                                                <td><strong>{{ app()->version() }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td>PHP Version:</td>
                                                <td><strong>{{ PHP_VERSION }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td>Server Software:</td>
                                                <td><strong>{{ $_SERVER['SERVER_SOFTWARE'] ?? 'N/A' }}</strong></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-sm">
                                            <tr>
                                                <td>Database:</td>
                                                <td><strong>{{ config('database.default') }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td>Timezone:</td>
                                                <td><strong>{{ config('app.timezone') }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td>Environment:</td>
                                                <td><strong>{{ config('app.env') }}</strong></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Tab persistence
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('#settingsTabs .nav-link');
        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                localStorage.setItem('lastSettingsTab', this.getAttribute('href'));
            });
        });

        // Restore last active tab
        const lastTab = localStorage.getItem('lastSettingsTab');
        if (lastTab) {
            const tab = document.querySelector(`a[href="${lastTab}"]`);
            if (tab) {
                new bootstrap.Tab(tab).show();
            }
        }
    });
</script>
@endpush
