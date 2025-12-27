@extends('layouts.app')

@section('title', $trainer->first_name . ' ' . $trainer->last_name . ' - Trainer Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Trainer Details</h3>
                        <div class="card-tools">
                            <a href="{{ route('trainers.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Back to Trainers
                            </a>
                            <a href="{{ route('trainers.edit', $trainer->id) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit"></i> Edit Trainer
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Profile Column -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    @if($trainer->profile_image)
                                        <img src="{{ asset('storage/' . $trainer->profile_image) }}"
                                             alt="{{ $trainer->first_name }} {{ $trainer->last_name }}"
                                             class="img-fluid rounded-circle mb-3"
                                             style="width: 200px; height: 200px; object-fit: cover;">
                                    @else
                                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                             style="width: 200px; height: 200px;">
                                            <i class="fas fa-user fa-5x text-muted"></i>
                                        </div>
                                    @endif

                                    <h3>{{ $trainer->first_name }} {{ $trainer->last_name }}</h3>
                                    <p class="text-muted">{{ $trainer->specialization }}</p>

                                    <div class="mt-3">
                                        <span class="badge badge-{{ $trainer->status == 'active' ? 'success' : ($trainer->status == 'inactive' ? 'danger' : 'warning') }} badge-lg">
                                            {{ ucfirst($trainer->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Information -->
                            <div class="card mt-3">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-address-card mr-2"></i>Contact Information
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-2">
                                        <strong><i class="fas fa-envelope mr-2"></i>Email:</strong><br>
                                        <a href="mailto:{{ $trainer->email }}">{{ $trainer->email }}</a>
                                    </div>

                                    @if($trainer->phone)
                                    <div class="mb-2">
                                        <strong><i class="fas fa-phone mr-2"></i>Phone:</strong><br>
                                        <a href="tel:{{ $trainer->phone }}">{{ $trainer->phone }}</a>
                                    </div>
                                    @endif

                                    @if($trainer->address)
                                    <div>
                                        <strong><i class="fas fa-map-marker-alt mr-2"></i>Address:</strong><br>
                                        {{ $trainer->address }}
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Quick Stats -->
                            <div class="card mt-3">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-chart-bar mr-2"></i>Quick Stats
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-6 mb-3">
                                            <div class="border rounded p-2">
                                                <h4 class="mb-1 text-primary">{{ $trainer->experience_years ?? 0 }}</h4>
                                                <small class="text-muted">Years Experience</small>
                                            </div>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <div class="border rounded p-2">
                                                <h4 class="mb-1 text-success">${{ number_format($trainer->hourly_rate ?? 0, 2) }}</h4>
                                                <small class="text-muted">Hourly Rate</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="border rounded p-2">
                                                <h4 class="mb-1 text-info">{{ $trainer->max_clients ?? 'N/A' }}</h4>
                                                <small class="text-muted">Max Clients</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="border rounded p-2">
                                                <h4 class="mb-1 text-warning">
                                                    {{ $trainer->clients_count ?? 0 }}
                                                </h4>
                                                <small class="text-muted">Current Clients</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Details Column -->
                        <div class="col-md-8">
                            <!-- Professional Information -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-briefcase mr-2"></i>Professional Information
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <strong>Specialization:</strong><br>
                                            {{ $trainer->specialization }}
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Experience:</strong><br>
                                            {{ $trainer->experience_years ?? '0' }} years
                                        </div>
                                    </div>

                                    @if($trainer->certifications)
                                    <div class="mb-3">
                                        <strong>Certifications:</strong><br>
                                        <div class="mt-1">
                                            @foreach(explode(',', $trainer->certifications) as $certification)
                                                <span class="badge badge-primary mr-1 mb-1">{{ trim($certification) }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif

                                    @if($trainer->bio)
                                    <div>
                                        <strong>Bio:</strong><br>
                                        <p class="mt-1">{{ $trainer->bio }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Personal Information -->
                            <div class="card mt-3">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-user mr-2"></i>Personal Information
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 mb-2">
                                            <strong>Date of Birth:</strong><br>
                                            {{ $trainer->date_of_birth ? $trainer->date_of_birth->format('M d, Y') : 'N/A' }}
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <strong>Gender:</strong><br>
                                            {{ $trainer->gender ? ucfirst($trainer->gender) : 'N/A' }}
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <strong>Age:</strong><br>
                                            @if($trainer->date_of_birth)
                                                {{ $trainer->date_of_birth->age }} years
                                            @else
                                                N/A
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Employment Details -->
                            <div class="card mt-3">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-calendar-alt mr-2"></i>Employment Details
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <strong>Hire Date:</strong><br>
                                            {{ $trainer->hire_date ? $trainer->hire_date->format('M d, Y') : 'N/A' }}
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <strong>Employment Duration:</strong><br>
                                            @if($trainer->hire_date)
                                                {{ $trainer->hire_date->diffForHumans() }}
                                            @else
                                                N/A
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="card mt-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 mb-2">
                                            <a href="{{ route('trainers.edit', $trainer->id) }}" class="btn btn-primary btn-block">
                                                <i class="fas fa-edit"></i> Edit Trainer
                                            </a>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <form action="{{ route('trainers.destroy', $trainer->id) }}" method="POST" class="d-inline" id="deleteForm">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-block" onclick="confirmDelete()">
                                                    <i class="fas fa-trash"></i> Delete Trainer
                                                </button>
                                            </form>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            @if($trainer->status == 'active')
                                                <form action="{{ route('trainers.deactivate', $trainer->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-warning btn-block">
                                                        <i class="fas fa-pause"></i> Deactivate
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('trainers.activate', $trainer->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-block">
                                                        <i class="fas fa-play"></i> Activate
                                                    </button>
                                                </form>
                                            @endif
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
</div>
@endsection

@push('scripts')
<script>
    function confirmDelete() {
        if (confirm('Are you sure you want to delete this trainer? This action cannot be undone.')) {
            document.getElementById('deleteForm').submit();
        }
    }

    // Add some interactive features
    document.addEventListener('DOMContentLoaded', function() {
        // Add loading animation to images
        const images = document.querySelectorAll('img');
        images.forEach(img => {
            img.addEventListener('load', function() {
                this.style.opacity = '1';
            });
            img.style.transition = 'opacity 0.3s ease';
            img.style.opacity = '0';
        });
    });
</script>
@endpush

@push('styles')
<style>
    .card {
        box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
        margin-bottom: 1rem;
    }
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }
    .badge-lg {
        font-size: 0.9em;
        padding: 0.5em 0.75em;
    }
    .border-rounded {
        border-radius: 0.5rem !important;
    }
    .btn-block {
        width: 100%;
    }
</style>
@endpush
