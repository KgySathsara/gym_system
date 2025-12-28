@extends('layouts.app')

@section('title', 'Members Management')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-users me-2"></i>Members Management</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('members.create') }}" class="btn btn-primary">
            <i class="fas fa-user-plus me-1"></i>Add New Member
        </a>
    </div>
</div>

<!-- Filters and Search -->
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('members.index') }}" method="GET">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="search" class="form-label">Search Members</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="search" name="search"
                               value="{{ request('search') }}" placeholder="Search by name or email...">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="trainer" class="form-label">Trainer</label>
                    <select class="form-select" id="trainer" name="trainer_id">
                        <option value="">All Trainers</option>
                        @foreach(\App\Models\Trainer::with('user')->get() as $trainer)
                            <option value="{{ $trainer->id }}" {{ request('trainer_id') == $trainer->id ? 'selected' : '' }}>
                                {{ $trainer->user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 mb-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Members Table -->
<div class="card">
    <div class="card-header bg-light">
        <h5 class="mb-0"><i class="fas fa-list me-2"></i>Members List</h5>
    </div>
    <div class="card-body">
        @if($members->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Member</th>
                            <th>Contact</th>
                            <th>Trainer</th>
                            <th>Plan</th>
                            <th>Join Date</th>
                            <th>Expiry</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($members as $member)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <img src="{{ $member->user->profile_image
                    ? asset('storage/profiles/' . $member->user->profile_image)
                    : asset('assets/images/default-avatar.png') }}"
                                             alt="{{ $member->user->name }}" class="rounded-circle" width="40" height="40">

                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0">{{ $member->user->name }}</h6>
                                        <small class="text-muted">ID: {{ $member->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <small class="d-block"><i class="fas fa-envelope me-1"></i>{{ $member->user->email }}</small>
                                    <small class="d-block"><i class="fas fa-phone me-1"></i>{{ $member->user->phone ?? 'N/A' }}</small>
                                </div>
                            </td>
                            <td>
                                @if($member->trainer)
                                    <span class="badge bg-info">{{ $member->trainer->user->name }}</span>
                                @else
                                    <span class="badge bg-secondary">No Trainer</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $member->plan->name }}</span>
                            </td>
                            <td>{{ $member->join_date->format('M d, Y') }}</td>
                            <td>
                                <span class="{{ $member->expiry_date->isPast() ? 'text-danger' : 'text-success' }}">
                                    {{ $member->expiry_date->format('M d, Y') }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $member->status == 'active' ? 'success' : ($member->status == 'inactive' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($member->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm table-actions">
                                    <a href="{{ route('members.show', $member->id) }}" class="btn btn-info"
                                       data-bs-toggle="tooltip" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('members.edit', $member->id) }}" class="btn btn-warning"
                                       data-bs-toggle="tooltip" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('members.destroy', $member->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                                data-bs-toggle="tooltip" title="Delete"
                                                onclick="return confirm('Are you sure you want to delete this member?')">
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
                    <p class="mb-0">Showing {{ $members->firstItem() }} to {{ $members->lastItem() }} of {{ $members->total() }} entries</p>
                </div>
                <div>
                    {{ $members->links() }}
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">No Members Found</h4>
                <p class="text-muted">There are no members matching your criteria.</p>
                <a href="{{ route('members.create') }}" class="btn btn-primary">
                    <i class="fas fa-user-plus me-1"></i>Add Your First Member
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
