@extends('layouts.app')

@section('title', 'Attendance Management')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-calendar-check me-2"></i>Attendance Management</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('attendance.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-1"></i>Record Attendance
            </a>
            <a href="{{ route('attendance.today') }}" class="btn btn-success">
                <i class="fas fa-list me-1"></i>Today's Attendance
            </a>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Today's Check-ins
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $attendanceStats['today_attendances'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Monthly Attendance
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $attendanceStats['monthly_attendances'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Avg Daily Attendance
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $attendanceStats['average_daily_attendance'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Active Members
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Member::where('status', 'active')->count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters and Search -->
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('attendance.index') }}" method="GET">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" class="form-control" id="search" name="search"
                           value="{{ request('search') }}" placeholder="Search by member name...">
                </div>
                <div class="col-md-2 mb-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" class="form-control" id="date" name="date"
                           value="{{ request('date') }}">
                </div>
                <div class="col-md-2 mb-3">
                    <label for="workout_type" class="form-label">Workout Type</label>
                    <select class="form-select" id="workout_type" name="workout_type">
                        <option value="">All Types</option>
                        <option value="cardio" {{ request('workout_type') == 'cardio' ? 'selected' : '' }}>Cardio</option>
                        <option value="strength" {{ request('workout_type') == 'strength' ? 'selected' : '' }}>Strength</option>
                        <option value="yoga" {{ request('workout_type') == 'yoga' ? 'selected' : '' }}>Yoga</option>
                        <option value="crossfit" {{ request('workout_type') == 'crossfit' ? 'selected' : '' }}>CrossFit</option>
                        <option value="swimming" {{ request('workout_type') == 'swimming' ? 'selected' : '' }}>Swimming</option>
                        <option value="dance" {{ request('workout_type') == 'dance' ? 'selected' : '' }}>Dance</option>
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="start_date" class="form-label">From Date</label>
                    <input type="date" class="form-control" id="start_date" name="start_date"
                           value="{{ request('start_date') }}">
                </div>
                <div class="col-md-2 mb-3">
                    <label for="end_date" class="form-label">To Date</label>
                    <input type="date" class="form-control" id="end_date" name="end_date"
                           value="{{ request('end_date') }}">
                </div>
                <div class="col-md-1 mb-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Attendance Table -->
<div class="card">
    <div class="card-header bg-light">
        <h5 class="mb-0"><i class="fas fa-list me-2"></i>Attendance Records</h5>
    </div>
    <div class="card-body">
        @if($attendances->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Member</th>
                            <th>Date</th>
                            <th>Check-in</th>
                            <th>Check-out</th>
                            <th>Duration</th>
                            <th>Workout Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendances as $attendance)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <img src="{{ $attendance->member->user->profile_image ? asset('storage/' . $attendance->member->user->profile_image) : asset('assets/images/default-avatar.png') }}"
                                             alt="{{ $attendance->member->user->name }}" class="rounded-circle" width="35" height="35">
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <h6 class="mb-0">{{ $attendance->member->user->name }}</h6>
                                        <small class="text-muted">{{ $attendance->member->user->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $attendance->date->format('M d, Y') }}</td>
                            <td>
                                <span class="badge bg-success">{{ $attendance->check_in->format('h:i A') }}</span>
                            </td>
                            <td>
                                @if($attendance->check_out)
                                    <span class="badge bg-danger">{{ $attendance->check_out->format('h:i A') }}</span>
                                @else
                                    <span class="badge bg-warning">Not Checked Out</span>
                                @endif
                            </td>
                            <td>
                                @if($attendance->workout_duration)
                                    <span class="badge bg-info">{{ $attendance->workout_duration }} mins</span>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                @if($attendance->workout_type)
                                    <span class="badge bg-secondary text-capitalize">{{ $attendance->workout_type }}</span>
                                @else
                                    <span class="text-muted">Not specified</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm table-actions">
                                    <a href="{{ route('attendance.show', $attendance->id) }}" class="btn btn-info"
                                       data-bs-toggle="tooltip" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('attendance.edit', $attendance->id) }}" class="btn btn-warning"
                                       data-bs-toggle="tooltip" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('attendance.destroy', $attendance->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                                data-bs-toggle="tooltip" title="Delete"
                                                onclick="return confirm('Are you sure you want to delete this attendance record?')">
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
                    <p class="mb-0">Showing {{ $attendances->firstItem() }} to {{ $attendances->lastItem() }} of {{ $attendances->total() }} entries</p>
                </div>
                <div>
                    {{ $attendances->links() }}
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-calendar-check fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">No Attendance Records Found</h4>
                <p class="text-muted">There are no attendance records matching your criteria.</p>
                <a href="{{ route('attendance.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-1"></i>Record First Attendance
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
