@extends('layouts.app')

@section('title', 'Edit Membership Plan')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-edit me-2"></i>Edit Membership Plan</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('plans.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Back to Plans
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="fas fa-clipboard-list me-2"></i>Edit Plan Information</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('plans.update', $plan->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Plan Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', $plan->name) }}" required
                                   placeholder="e.g., Basic Plan, Premium Plan">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">Price ($) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror"
                                   id="price" name="price" value="{{ old('price', $plan->price) }}" required
                                   min="0" placeholder="0.00">
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description" name="description" rows="3"
                                  placeholder="Brief description of the plan...">{{ old('description', $plan->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="duration_days" class="form-label">Duration (Days) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('duration_days') is-invalid @enderror"
                                   id="duration_days" name="duration_days" value="{{ old('duration_days', $plan->duration_days) }}"
                                   min="1" required>
                            @error('duration_days')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="sessions_per_week" class="form-label">Sessions/Week <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('sessions_per_week') is-invalid @enderror"
                                   id="sessions_per_week" name="sessions_per_week" value="{{ old('sessions_per_week', $plan->sessions_per_week) }}"
                                   min="1" max="7" required>
                            @error('sessions_per_week')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="has_trainer" class="form-label">Includes Trainer</label>
                            <select class="form-select @error('has_trainer') is-invalid @enderror" id="has_trainer" name="has_trainer">
                                <option value="0" {{ old('has_trainer', $plan->has_trainer) == 0 ? 'selected' : '' }}>No</option>
                                <option value="1" {{ old('has_trainer', $plan->has_trainer) == 1 ? 'selected' : '' }}>Yes</option>
                            </select>
                            @error('has_trainer')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="features" class="form-label">Plan Features</label>
                        <textarea class="form-control @error('features') is-invalid @enderror"
                                  id="features" name="features" rows="4"
                                  placeholder="Enter each feature on a new line&#10;e.g.,&#10;Gym Access&#10;Locker Room&#10;Personal Trainer">@if(old('features')){{ old('features') }}@elseif($plan->features && is_array($plan->features)){{ implode("\n", $plan->features) }}@elseif($plan->features && is_string($plan->features)){{ $plan->features }}@endif</textarea>
                        @error('features')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Enter each feature on a separate line.</div>
                    </div>

                    <div class="mb-3 form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                               value="1" {{ old('is_active', $plan->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Activate this plan</label>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('plans.index') }}" class="btn btn-secondary me-md-2">
                            <i class="fas fa-times me-1"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save me-1"></i>Update Plan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Plan Preview -->
        <div class="card">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0"><i class="fas fa-eye me-2"></i>Plan Preview</h6>
            </div>
            <div class="card-body">
                <div id="plan-preview">
                    <div class="text-center mb-3">
                        <h4 id="preview-name" class="text-primary">{{ $plan->name }}</h4>
                        <h2 id="preview-price" class="text-success">${{ number_format($plan->price, 2) }}</h2>
                        <p id="preview-duration" class="text-muted">per {{ $plan->duration_days }} days</p>
                    </div>

                    <div class="mb-3">
                        <p id="preview-description" class="card-text text-muted">{{ $plan->description ?: 'Plan description will appear here.' }}</p>
                    </div>

                    <div class="mb-3">
                        <h6>Plan Features:</h6>
                        <ul id="preview-features" class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i><span id="preview-sessions">{{ $plan->sessions_per_week }}</span> sessions/week</li>
                            <li>
                                <i class="fas fa-{{ $plan->has_trainer ? 'check text-success' : 'times text-danger' }} me-2"></i>
                                Personal Trainer
                            </li>
                            @if($plan->features && is_array($plan->features))
                                @foreach($plan->features as $feature)
                                    <li><i class="fas fa-check text-success me-2"></i>{{ $feature }}</li>
                                @endforeach
                            @endif
                        </ul>
                    </div>

                    <div class="text-center">
                        <span class="badge bg-{{ $plan->is_active ? 'success' : 'secondary' }}">
                            {{ $plan->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Plan Stats -->
        <div class="card mt-4">
            <div class="card-header bg-light">
                <h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Plan Statistics</h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6 mb-3">
                        <div class="border rounded p-2">
                            <h5 class="text-primary mb-1">{{ $plan->members->count() }}</h5>
                            <small class="text-muted">Active Members</small>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="border rounded p-2">
                            <h5 class="text-success mb-1">{{ $plan->payments->where('status', 'completed')->count() }}</h5>
                            <small class="text-muted">Total Payments</small>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <small class="text-muted">Created: {{ $plan->created_at->format('M d, Y') }}</small><br>
                    <small class="text-muted">Last Updated: {{ $plan->updated_at->format('M d, Y') }}</small>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card mt-4">
            <div class="card-header bg-light">
                <h6 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('plans.show', $plan->id) }}" class="btn btn-outline-info btn-sm">
                        <i class="fas fa-eye me-1"></i>View Plan Details
                    </a>
                    @if($plan->is_active)
                        <form action="{{ route('plans.toggle-status', $plan->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-outline-warning btn-sm w-100">
                                <i class="fas fa-pause me-1"></i>Deactivate Plan
                            </button>
                        </form>
                    @else
                        <form action="{{ route('plans.toggle-status', $plan->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-outline-success btn-sm w-100">
                                <i class="fas fa-play me-1"></i>Activate Plan
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.plan-card {
    transition: transform 0.2s, box-shadow 0.2s;
}
.plan-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}
</style>
@endpush

@push('scripts')
<script>
    // Real-time plan preview
    function updatePreview() {
        // Name
        const nameElement = document.getElementById('preview-name');
        if (nameElement) {
            nameElement.textContent = document.getElementById('name').value || 'Plan Name';
        }

        // Price
        const price = document.getElementById('price').value || '0';
        const priceElement = document.getElementById('preview-price');
        if (priceElement) {
            priceElement.textContent = '$' + parseFloat(price).toFixed(2);
        }

        // Duration
        const duration = document.getElementById('duration_days').value || '0';
        const durationElement = document.getElementById('preview-duration');
        if (durationElement) {
            durationElement.textContent = 'per ' + duration + ' days';
        }

        // Description
        const descriptionElement = document.getElementById('preview-description');
        if (descriptionElement) {
            descriptionElement.textContent = document.getElementById('description').value || 'Plan description will appear here.';
        }

        // Sessions per week
        const sessions = document.getElementById('sessions_per_week').value || '0';
        const sessionsElement = document.getElementById('preview-sessions');
        if (sessionsElement) {
            sessionsElement.textContent = sessions;
        }

        // Trainer included
        const hasTrainer = document.getElementById('has_trainer').value === '1';
        const trainerIcon = document.querySelector('#preview-features li:nth-child(2) i');
        const trainerText = document.querySelector('#preview-features li:nth-child(2)');

        if (trainerIcon && trainerText) {
            if (hasTrainer) {
                trainerIcon.className = 'fas fa-check text-success me-2';
                trainerText.innerHTML = '<i class="fas fa-check text-success me-2"></i>Personal Trainer';
            } else {
                trainerIcon.className = 'fas fa-times text-danger me-2';
                trainerText.innerHTML = '<i class="fas fa-times text-danger me-2"></i>Personal Trainer';
            }
        }

        // Features list
        const featuresText = document.getElementById('features').value;
        const featuresList = document.getElementById('preview-features');
        if (featuresList) {
            const existingFeatures = featuresList.querySelectorAll('li:not(:first-child):not(:nth-child(2))');

            // Remove existing feature items (except first two fixed items)
            existingFeatures.forEach(li => li.remove());

            // Add new feature items
            if (featuresText) {
                const features = featuresText.split('\n').filter(f => f.trim() !== '');
                features.forEach(feature => {
                    if (feature.trim()) {
                        const li = document.createElement('li');
                        li.innerHTML = `<i class="fas fa-check text-success me-2"></i>${feature.trim()}`;
                        featuresList.appendChild(li);
                    }
                });
            }
        }
    }

    // Add event listeners to all form fields
    const formFields = ['name', 'price', 'description', 'duration_days', 'sessions_per_week', 'has_trainer', 'features'];
    formFields.forEach(field => {
        const element = document.getElementById(field);
        if (element) {
            element.addEventListener('input', updatePreview);
            element.addEventListener('change', updatePreview);
        }
    });

    // Initial preview update
    updatePreview();
</script>
@endpush
