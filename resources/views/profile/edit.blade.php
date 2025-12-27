@extends('layouts.app')

@section('title', 'My Profile')
@section('subtitle', 'Manage your account settings and profile information')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <!-- Profile Card -->
            <div class="card">
                <div class="card-body text-center">
                    @if(auth()->user()->profile_image)
                        <img src="{{ asset('storage/profiles/' . auth()->user()->profile_image) }}"
                             alt="{{ auth()->user()->name }}"
                             class="img-fluid rounded-circle mb-3"
                             style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                             style="width: 150px; height: 150px;">
                            <i class="fas fa-user fa-4x text-white"></i>
                        </div>
                    @endif

                    <h4>{{ auth()->user()->name }}</h4>
                    <p class="text-muted">{{ auth()->user()->email }}</p>

                    <div class="mt-3">
                        <span class="badge bg-success">Administrator</span>
                    </div>

                    <div class="mt-4">
                        <small class="text-muted">
                            <i class="fas fa-calendar-alt me-1"></i>
                            Member since {{ auth()->user()->created_at->format('M Y') }}
                        </small>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="card-title mb-0">Account Overview</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>Last Login:</span>
                        <strong>{{ auth()->user()->last_login_at ? auth()->user()->last_login_at->diffForHumans() : 'Never' }}</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>Account Status:</span>
                        <span class="badge bg-success">Active</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Email Verified:</span>
                        @if(auth()->user()->email_verified_at)
                            <span class="badge bg-success">Verified</span>
                        @else
                            <span class="badge bg-warning">Pending</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <!-- Profile Information Form -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Profile Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Full Name *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label">Email Address *</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                           id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                           id="phone" name="phone" value="{{ old('phone', auth()->user()->phone) }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="profile_image" class="form-label">Profile Image</label>
                                    <input type="file" class="form-control @error('profile_image') is-invalid @enderror"
                                           id="profile_image" name="profile_image" accept="image/*">
                                    @error('profile_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Max file size: 2MB. Allowed types: JPEG, PNG, JPG, GIF.</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control @error('address') is-invalid @enderror"
                                      id="address" name="address" rows="3">{{ old('address', auth()->user()->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Change Password Form -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Change Password</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                   id="current_password" name="current_password">
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="new_password" class="form-label">New Password</label>
                                    <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                                           id="new_password" name="new_password">
                                    @error('new_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control"
                                           id="new_password_confirmation" name="new_password_confirmation">
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-key me-2"></i>Change Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
