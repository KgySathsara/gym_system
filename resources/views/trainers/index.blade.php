@extends('layouts.app')

@section('title', 'Trainers Management')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-user-tie me-2"></i>Trainers Management</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('trainers.create') }}" class="btn btn-primary">
            <i class="fas fa-user-plus me-1"></i>Add New Trainer
        </a>
    </div>
</div>

<!-- Filters and Search -->
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('trainers.index') }}" method="GET">
            <div class="row">
                <div class="col-md-5 mb-3">
                    <label for="search" class="form-label">Search Trainers</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="search" name="search"
                               value="{{ request('search') }}" placeholder="Search by name, email, or specialization...">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="specialization" class="form-label">Specialization</label>
                    <select class="form-select" id="specialization" name="specialization">
                        <option value="">All Specializations</option>
                        <option value="Personal Training" {{ request('specialization') == 'Personal Training' ? 'selected' : '' }}>Personal Training</option>
                        <option value="Yoga" {{ request('specialization') == 'Yoga' ? 'selected' : '' }}>Yoga</option>
                        <option value="Pilates" {{ request('specialization') == 'Pilates' ? 'selected' : '' }}>Pilates</option>
                        <option value="CrossFit" {{ request('specialization') == 'CrossFit' ? 'selected' : '' }}>CrossFit</option>
                        <option value="Weight Loss" {{ request('specialization') == 'Weight Loss' ? 'selected' : '' }}>Weight Loss</option>
                        <option value="Body Building" {{ request('specialization') == 'Body Building' ? 'selected' : '' }}>Body Building</option>
                        <option value="Rehabilitation" {{ request('specialization') == 'Rehabilitation' ? 'selected' : '' }}>Rehabilitation</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Trainers Table -->
<div class="card">
    <div class="card-header bg-light">
        <h5 class="mb-0"><i class="fas fa-list me-2"></i>Trainers List</h5>
    </div>
    <div class="card-body">
        @if($trainers->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Trainer</th>
                            <th>Specialization</th>
                            <th>Experience</th>
                            <th>Hourly Rate</th>
                            <th>Members</th>
                            <th>Availability</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trainers as $trainer)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <img src="{{ $trainer->user->profile_image ? asset('storage/profiles/' . $trainer->user->profile_image) : asset('assets/images/default-avatar.png') }}"
                                            alt="{{ $trainer->user->name }}" class="rounded-circle" width="40" height="40">
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0">{{ $trainer->user->name }}</h6>
                                        <small class="text-muted">{{ $trainer->user->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $trainer->specialization }}</span>
                            </td>
                            <td>{{ $trainer->experience_years }} years</td>
                            <td>${{ number_format($trainer->hourly_rate, 2) }}/hr</td>
                            <td>
                                <span class="badge bg-primary">{{ $trainer->members_count ?? $trainer->members->count() }}</span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $trainer->is_available ? 'success' : 'secondary' }}">
                                    {{ $trainer->is_available ? 'Available' : 'Not Available' }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm table-actions">
                                    <a href="{{ route('trainers.show', $trainer->id) }}" class="btn btn-info"
                                       data-bs-toggle="tooltip" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('trainers.edit', $trainer->id) }}" class="btn btn-warning"
                                       data-bs-toggle="tooltip" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('trainers.destroy', $trainer->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                                data-bs-toggle="tooltip" title="Delete"
                                                onclick="return confirm('Are you sure you want to delete this trainer?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    <p class="mb-0">Showing {{ $trainers->firstItem() }} to {{ $trainers->lastItem() }} of {{ $trainers->total() }} entries</p>
                </div>
                <div>
                    {{ $trainers->links() }}
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-user-tie fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">No Trainers Found</h4>
                <p class="text-muted">There are no trainers matching your criteria.</p>
                <a href="{{ route('trainers.create') }}" class="btn btn-primary">
                    <i class="fas fa-user-plus me-1"></i>Add Your First Trainer
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endpush
