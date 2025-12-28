@extends('layouts.app')

@section('title', 'Edit Trainer')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Trainer</h3>
                    <div class="card-tools">
                        <a href="{{ route('trainers.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Trainers
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form id="editTrainerForm" action="{{ route('trainers.update', $trainer->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Personal Information -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Personal Information</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Full Name *</label>
                                                    <input type="text"
                                                           class="form-control @error('name') is-invalid @enderror"
                                                           id="name"
                                                           name="name"
                                                           value="{{ old('name', $trainer->name) }}"
                                                           required>
                                                    @error('name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            {{-- <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="last_name">Last Name *</label>
                                                    <input type="text"
                                                           class="form-control @error('last_name') is-invalid @enderror"
                                                           id="last_name"
                                                           name="last_name"
                                                           value="{{ old('last_name', $trainer->last_name) }}"
                                                           required>
                                                    @error('last_name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div> --}}
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="email">Email Address *</label>
                                                    <input type="email"
                                                           class="form-control @error('email') is-invalid @enderror"
                                                           id="email"
                                                           name="email"
                                                           value="{{ old('email', $trainer->email) }}"
                                                           required>
                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="phone">Phone Number</label>
                                                    <input type="tel"
                                                           class="form-control @error('phone') is-invalid @enderror"
                                                           id="phone"
                                                           name="phone"
                                                           value="{{ old('phone', $trainer->phone) }}">
                                                    @error('phone')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="date_of_birth">Date of Birth</label>
                                                    <input type="date"
                                                           class="form-control @error('date_of_birth') is-invalid @enderror"
                                                           id="date_of_birth"
                                                           name="date_of_birth"
                                                           value="{{ old('date_of_birth', $trainer->date_of_birth ? $trainer->date_of_birth->format('Y-m-d') : '') }}">
                                                    @error('date_of_birth')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="gender">Gender</label>
                                                    <select class="form-control @error('gender') is-invalid @enderror"
                                                            id="gender"
                                                            name="gender">
                                                        <option value="">Select Gender</option>
                                                        <option value="male" {{ old('gender', $trainer->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                                        <option value="female" {{ old('gender', $trainer->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                                        <option value="other" {{ old('gender', $trainer->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                                    </select>
                                                    @error('gender')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <textarea class="form-control @error('address') is-invalid @enderror"
                                                      id="address"
                                                      name="address"
                                                      rows="3">{{ old('address', $trainer->address) }}</textarea>
                                            @error('address')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Professional Information -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Professional Information</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                            <label for="specialization">Specialization <span class="text-danger">*</span></label>

                            <select
                                class="form-control @error('specialization') is-invalid @enderror"
                                id="specialization"
                                name="specialization"
                                required
                            >
                                <option value="">Select Specialization</option>

                                @php
                                    $specializations = [
                                        'Personal Training',
                                        'Yoga',
                                        'Pilates',
                                        'CrossFit',
                                        'Weight Loss',
                                        'Body Building',
                                        'Rehabilitation',
                                    ];

                                    $selectedSpecialization = old('specialization', $trainer->specialization);
                                @endphp

                                @foreach($specializations as $specialization)
                                    <option value="{{ $specialization }}"
                                        {{ $selectedSpecialization === $specialization ? 'selected' : '' }}>
                                        {{ $specialization }}
                                    </option>
                                @endforeach
                            </select>

                            @error('specialization')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                                        <div class="form-group">
                                            <label for="certifications">Certifications</label>
                                            <textarea class="form-control @error('certifications') is-invalid @enderror"
                                                      id="certifications"
                                                      name="certifications"
                                                      rows="3"
                                                      placeholder="List certifications separated by commas">{{ old('certifications', $trainer->certifications) }}</textarea>
                                            @error('certifications')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="experience_years">Experience (Years)</label>
                                                    <input type="number"
                                                           class="form-control @error('experience_years') is-invalid @enderror"
                                                           id="experience_years"
                                                           name="experience_years"
                                                           min="0"
                                                           max="50"
                                                           value="{{ old('experience_years', $trainer->experience_years) }}">
                                                    @error('experience_years')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="hourly_rate">Hourly Rate ($)</label>
                                                    <input type="number"
                                                           class="form-control @error('hourly_rate') is-invalid @enderror"
                                                           id="hourly_rate"
                                                           name="hourly_rate"
                                                           min="0"
                                                           step="0.01"
                                                           value="{{ old('hourly_rate', $trainer->hourly_rate) }}">
                                                    @error('hourly_rate')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="bio">Bio/Description</label>
                                            <textarea class="form-control @error('bio') is-invalid @enderror"
                                                      id="bio"
                                                      name="bio"
                                                      rows="4">{{ old('bio', $trainer->bio) }}</textarea>
                                            @error('bio')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Profile Image -->
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h4 class="card-title">Profile Image</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="profile_image">Upload New Image</label>
                                            <div class="custom-file">
                                                <input type="file"
                                                       class="custom-file-input @error('profile_image') is-invalid @enderror"
                                                       id="profile_image"
                                                       name="profile_image"
                                                       accept="image/*">
                                                <label class="custom-file-label" for="profile_image">Choose file</label>
                                                @error('profile_image')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        @if($trainer->profile_image)
                                            <div class="mt-2">
                                                <p>Current Image:</p>
                                                <img src="{{ asset('storage/' . $trainer->profile_image) }}"
                                                     alt="{{ $trainer->first_name }} {{ $trainer->last_name }}"
                                                     class="img-thumbnail"
                                                     style="max-width: 200px; max-height: 200px;">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status and Availability -->
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Status & Availability</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="status">Status</label>
                                                    <select class="form-control @error('status') is-invalid @enderror"
                                                            id="status"
                                                            name="status">
                                                        <option value="active" {{ old('status', $trainer->status) == 'active' ? 'selected' : '' }}>Active</option>
                                                        <option value="inactive" {{ old('status', $trainer->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                        <option value="on_leave" {{ old('status', $trainer->status) == 'on_leave' ? 'selected' : '' }}>On Leave</option>
                                                    </select>
                                                    @error('status')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="hire_date">Hire Date</label>
                                                    <input type="date"
                                                           class="form-control @error('hire_date') is-invalid @enderror"
                                                           id="hire_date"
                                                           name="hire_date"
                                                           value="{{ old('hire_date', $trainer->hire_date ? $trainer->hire_date->format('Y-m-d') : '') }}">
                                                    @error('hire_date')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="max_clients">Max Clients</label>
                                                    <input type="number"
                                                           class="form-control @error('max_clients') is-invalid @enderror"
                                                           id="max_clients"
                                                           name="max_clients"
                                                           min="1"
                                                           max="50"
                                                           value="{{ old('max_clients', $trainer->max_clients) }}">
                                                    @error('max_clients')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update Trainer
                                    </button>
                                    <a href="{{ route('trainers.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // File input label update
        $('#profile_image').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName);
        });

        // Form validation
        $('#editTrainerForm').validate({
            rules: {
                first_name: {
                    required: true,
                    minlength: 2
                },
                last_name: {
                    required: true,
                    minlength: 2
                },
                email: {
                    required: true,
                    email: true
                },
                specialization: {
                    required: true
                },
                hourly_rate: {
                    min: 0,
                    number: true
                },
                experience_years: {
                    min: 0,
                    max: 50,
                    digits: true
                },
                max_clients: {
                    min: 1,
                    max: 50,
                    digits: true
                }
            },
            messages: {
                first_name: {
                    required: "Please enter first name",
                    minlength: "First name must be at least 2 characters long"
                },
                last_name: {
                    required: "Please enter last name",
                    minlength: "Last name must be at least 2 characters long"
                },
                email: {
                    required: "Please enter email address",
                    email: "Please enter a valid email address"
                },
                specialization: {
                    required: "Please enter specialization"
                }
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });

        // Phone number formatting
        $('#phone').inputmask('(999) 999-9999');
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
    .form-group {
        margin-bottom: 1.5rem;
    }
    .img-thumbnail {
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        padding: 0.25rem;
    }
</style>
@endpush
