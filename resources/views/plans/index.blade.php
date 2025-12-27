@extends('layouts.app')

@section('title', 'Membership Plans')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="display-6 fw-bold text-primary mb-2">
                <i class="fas fa-clipboard-list me-2"></i>Membership Plans
            </h1>
            <p class="text-muted">Manage and customize your gym membership offerings</p>
        </div>
        <a href="{{ route('plans.create') }}" class="btn btn-primary btn-lg shadow-sm">
            <i class="fas fa-plus-circle me-2"></i>Create New Plan
        </a>
    </div>

    <!-- Plans Grid -->
    <div class="row g-4">
        @foreach($plans as $plan)
        <div class="col-xl-4 col-lg-6 col-md-6">
            <div class="card plan-card h-100 border-0 shadow-sm position-relative overflow-hidden">
                <!-- Status Badge -->
                @if(!$plan->is_active)
                <div class="position-absolute top-0 start-0 m-3">
                    <span class="badge bg-secondary py-2 px-3">
                        <i class="fas fa-pause-circle me-1"></i>Inactive
                    </span>
                </div>
                @endif

                <!-- Popular Badge -->
                @if($plan->is_popular)
                <div class="position-absolute top-0 end-0 m-3">
                    <span class="badge bg-warning text-dark py-2 px-3">
                        <i class="fas fa-star me-1"></i>Most Popular
                    </span>
                </div>
                @endif

                <!-- Card Header -->
                <div class="card-header bg-gradient-primary text-white py-4 border-0 position-relative">
                    <div class="position-absolute top-0 end-0 w-100 h-100 opacity-10">
                        <div class="pattern-dots"></div>
                    </div>
                    <h4 class="card-title mb-2 text-center fw-bold">{{ $plan->name }}</h4>
                    <div class="text-center">
                        <h2 class="display-5 fw-bold mb-1">${{ number_format($plan->price, 2) }}</h2>
                        <p class="mb-0 opacity-75">per {{ $plan->duration_days }} days</p>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body p-4">
                    <!-- Description -->
                    <p class="card-text text-muted mb-4 text-center">{{ $plan->description }}</p>

                    <!-- Features -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-uppercase text-primary mb-3">
                            <i class="fas fa-list-check me-2"></i>Plan Features
                        </h6>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2 d-flex align-items-center">
                                <i class="fas fa-dumbbell text-success me-3 fs-5"></i>
                                <span>{{ $plan->sessions_per_week }} sessions per week</span>
                            </li>
                            <li class="mb-2 d-flex align-items-center">
                                <i class="fas {{ $plan->has_trainer ? 'fa-check text-success' : 'fa-times text-danger' }} me-3 fs-5"></i>
                                <span>Personal Trainer {{ $plan->has_trainer ? 'Included' : 'Not Included' }}</span>
                            </li>
                            @if($plan->features && is_array($plan->features))
                                @foreach($plan->features as $feature)
                                <li class="mb-2 d-flex align-items-center">
                                    <i class="fas fa-check text-success me-3 fs-5"></i>
                                    <span>{{ $feature }}</span>
                                </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>

                    <!-- Stats -->
                    <div class="row g-3 text-center mt-4 pt-3 border-top">
                        <div class="col-4">
                            <div class="bg-light rounded p-2">
                                <small class="text-muted d-block">Duration</small>
                                <span class="fw-bold text-primary fs-5">{{ $plan->duration_days }}</span>
                                <small class="text-muted d-block">days</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="bg-light rounded p-2">
                                <small class="text-muted d-block">Sessions</small>
                                <span class="fw-bold text-primary fs-5">{{ $plan->sessions_per_week }}</span>
                                <small class="text-muted d-block">per week</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="bg-light rounded p-2">
                                <small class="text-muted d-block">Status</small>
                                <span class="fw-bold fs-5 {{ $plan->is_active ? 'text-success' : 'text-secondary' }}">
                                    {{ $plan->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Footer -->
                <div class="card-footer bg-transparent border-0 p-4 pt-0">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('plans.show', $plan->id) }}" class="btn btn-outline-primary btn-sm flex-fill">
                            <i class="fas fa-eye me-1"></i>View
                        </a>
                        <a href="{{ route('plans.edit', $plan->id) }}" class="btn btn-outline-warning btn-sm flex-fill">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <form action="{{ route('plans.destroy', $plan->id) }}" method="POST" class="d-inline flex-fill">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm w-100"
                                    onclick="return confirm('Are you sure you want to delete this plan?')">
                                <i class="fas fa-trash me-1"></i>Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if($plans->count() == 0)
    <!-- Empty State -->
    <div class="text-center py-5 my-5">
        <div class="empty-state-icon mb-4">
            <i class="fas fa-clipboard-list text-muted" style="font-size: 4rem;"></i>
        </div>
        <h3 class="text-muted mb-3">No Membership Plans Yet</h3>
        <p class="text-muted mb-4">Start by creating your first membership plan to attract new members</p>
        <a href="{{ route('plans.create') }}" class="btn btn-primary btn-lg px-4">
            <i class="fas fa-plus-circle me-2"></i>Create First Plan
        </a>
    </div>
    @endif

    <!-- Pagination -->
    @if($plans->hasPages())
    <div class="d-flex justify-content-center mt-5 pt-4">
        <nav aria-label="Plan pagination">
            {{ $plans->links() }}
        </nav>
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
:root {
    --primary-color: #4361ee;
    --secondary-color: #3a0ca3;
    --success-color: #4cc9f0;
    --gradient-primary: linear-gradient(135deg, #4361ee, #3a0ca3);
}

.bg-gradient-primary {
    background: var(--gradient-primary) !important;
}

.plan-card {
    transition: all 0.3s ease;
    border-radius: 16px;
    overflow: hidden;
}

.plan-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15) !important;
}

.card-header {
    border-radius: 16px 16px 0 0 !important;
}

.pattern-dots {
    background-image: radial-gradient(circle, rgba(255,255,255,0.3) 1px, transparent 1px);
    background-size: 15px 15px;
    opacity: 0.3;
}

.empty-state-icon {
    opacity: 0.5;
}

.btn {
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.2s ease;
}

.btn-outline-primary:hover {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

.badge {
    border-radius: 8px;
    font-weight: 500;
}

.list-unstyled li {
    padding: 8px 0;
    border-bottom: 1px solid rgba(0,0,0,0.05);
}

.list-unstyled li:last-child {
    border-bottom: none;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .display-6 {
        font-size: 1.8rem;
    }

    .card-header h4 {
        font-size: 1.3rem;
    }

    .display-5 {
        font-size: 2rem;
    }
}

/* Pagination styling */
.pagination .page-link {
    border-radius: 8px;
    margin: 0 4px;
    border: 1px solid #dee2e6;
    color: var(--primary-color);
}

.pagination .page-item.active .page-link {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

.pagination .page-link:hover {
    background-color: #e9ecef;
    border-color: #dee2e6;
}
</style>
@endpush
