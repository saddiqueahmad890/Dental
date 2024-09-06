@extends('layouts.layout')
@section('content')
    {{-- <style>
        /* Style for the input field when it has an error */
        input.parsley-error {
            border-color: #ff4d4d;
            box-shadow: 0 0 5px #ff4d4d;
        }

        /* Style for the input field when it passes validation */
        input.parsley-success {
            border-color: #28a745;
            box-shadow: 0 0 5px #28a745;
        }

        /* Style for the error messages */
        .parsley-errors-list {
            list-style-type: none;
            padding: 0;
            margin: 5px 0 0;
            color: #ff4d4d;
            font-size: 0.875rem;
            position: static;
            /* Ensure the error message stays below the input field */
            display: block;
            /* Ensure the error message takes up full width below the field */
            width: 100%;
            /* Make sure the error message aligns with the input field width */
        }

        /* Style the error icon */
        .parsley-errors-list li:before {
            content: "⚠ ";
            margin-right: 5px;
            font-size: 1rem;
        }

        /* Style the success icon for validated fields */
        input.parsley-success+.input-group-prepend .input-group-text {
            color: #28a745;
        }

        input.parsley-error+.input-group-prepend .input-group-text {
            color: #ff4d4d;
        }
    </style> --}}
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3>
                        <a href="{{ route('doctor-details.index') }}" class="btn btn-outline btn-info">
                            <i class="fas fa-eye"></i> @lang('View All')
                        </a>
                        <span class="pull-right"></span>
                    </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('doctor-details.index') }}">@lang('Doctor')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('Add Doctor')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Add Doctor')</h3>
                </div>
                <div class="card-body">
                    <form id="departmentForm" data-parsley-validate class="form-material form-horizontal bg-custom"
                        action="{{ route('doctor-details.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Name Field -->
                        <div class="row col-12 p-0 m-0">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="name">@lang('Name') <b class="ambitious-crimson">*</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                        </div>
                                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                                            class="form-control @error('name') is-invalid @enderror"
                                            placeholder="@lang('Name')" required
                                            data-parsley-required-message="Please enter doctor's name">
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Email Field -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="email">@lang('Email') <b class="ambitious-crimson">*</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-at"></i></span>
                                        </div>
                                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                                            class="form-control @error('email') is-invalid @enderror"
                                            placeholder="@lang('Email')" required
                                            data-parsley-required-message="Please enter a valid email"
                                            data-parsley-type="email">
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Password Field -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="password">@lang('Password') <b class="ambitious-crimson">*</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                                        </div>
                                        <input type="password" id="password" name="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="@lang('Password')" required
                                            data-parsley-required-message="Please enter password">
                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Phone Field -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="phone">@lang('Phone')</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        </div>
                                        <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                                            class="form-control @error('phone') is-invalid @enderror"
                                            placeholder="@lang('Phone')" data-parsley-type="digits"
                                            data-parsley-required-message="Please enter a valid phone number">
                                        @error('phone')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Date of Birth Field -->
                        <div class="row col-12 p-0 m-0">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="date_of_birth">@lang('Date of Birth')</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-check"></i></span>
                                        </div>
                                        <input type="text" name="date_of_birth" id="date_of_birth"
                                            value="{{ old('date_of_birth') }}"
                                            class="form-control flatpickr @error('date_of_birth') is-invalid @enderror"
                                            placeholder="@lang('Date of Birth')"
                                            data-parsley-required-message="Please enter a valid date in the format YYYY-MM-DD"
                                            data-parsley-pattern="\d{4}-\d{2}-\d{2}">
                                        @error('date_of_birth')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Specialist Field -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="specialist">@lang('Specialist')</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-street-view"></i></span>
                                        </div>
                                        <input type="text" id="specialist" name="specialist"
                                            value="{{ old('specialist') }}"
                                            class="form-control @error('specialist') is-invalid @enderror"
                                            placeholder="@lang('Specialist')">
                                        @error('specialist')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Designation Field -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="designation">@lang('Designation')</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                                        </div>
                                        <input type="text" id="designation" name="designation"
                                            value="{{ old('designation') }}"
                                            class="form-control @error('designation') is-invalid @enderror"
                                            placeholder="@lang('Designation')">
                                        @error('designation')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Gender Field -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="gender">@lang('Gender')</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                        </div>
                                        <select name="gender" class="form-control @error('gender') is-invalid @enderror"
                                            id="gender">
                                            <option value="">--@lang('Select')--</option>
                                            <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>
                                                @lang('Male')</option>
                                            <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>
                                                @lang('Female')</option>
                                        </select>
                                        @error('gender')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Blood Group Field -->
                        <div class="row col-12 p-0 m-0">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="blood_group">@lang('Blood Group')</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-heartbeat"></i></span>
                                        </div>
                                        <select name="blood_group"
                                            class="form-control select2 @error('blood_group') is-invalid @enderror"
                                            id="blood_group">
                                            <option value="" disabled {{ old('blood_group') ? '' : 'selected' }}>
                                                Select Blood Group</option>
                                            @foreach ($bloodGroups as $bloodGroup)
                                                <option value="{{ $bloodGroup->id }}"
                                                    {{ old('blood_group') == $bloodGroup->id ? 'selected' : '' }}>
                                                    {{ $bloodGroup->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('blood_group')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Commission Field -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="commission">@lang('Commission') %</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-percent"></i></span>
                                        </div>
                                        <input type="number" id="commission" name="commission"
                                            value="{{ old('commission') }}"
                                            class="form-control @error('commission') is-invalid @enderror"
                                            placeholder="@lang('Commission')" min="1" max="100" required
                                            data-parsley-required-message="Please enter a commission percentage"
                                            data-parsley-type="digits" data-parsley-min="1" data-parsley-max="100"
                                            data-parsley-min-message="Commission must be at least 1"
                                            data-parsley-max-message="Commission cannot exceed 100">
                                        @error('commission')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- address Field -->
                        <div class="row  col-12 p-0 m-0">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address">@lang('Address')</label>
                                    <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror" rows="4"
                                        placeholder="@lang('Address')">{{ old('address') }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="doctor_biography">@lang('Biography')</label>
                                    <textarea name="doctor_biography" id="doctor_biography"
                                        class="form-control @error('doctor_biography') is-invalid @enderror" rows="4"
                                        placeholder="@lang('I am a Doctor')">{{ old('doctor_biography') }}</textarea>
                                    @error('doctor_biography')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row  col-12 p-0 m-0">
                            <div class="col-md-6">
                                <label for="photo" class="col-md-12 col-form-label">
                                    <h4>{{ __('Photo') }}</h4>
                                </label>
                                <div class="col-md-12">
                                    <input id="photo" class="dropify" name="photo" type="file"
                                        data-allowed-file-extensions="png jpg jpeg" data-max-file-size="2024K" />
                                    <p>{{ __('Max Size: 1000kb, Allowed Format: png, jpg, jpeg') }}</p>
                                </div>
                                @error('photo')
                                    <div class="error ambitious-red">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit and Cancel Buttons -->
                        <div class="row  col-12 p-0 m-0">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 col-form-label"></label>
                                    <div class="col-md-8">
                                        <input type="submit" value="{{ __('Submit') }}"
                                            class="btn btn-outline btn-info btn-lg" />
                                        <a href="{{ route('doctor-details.index') }}"
                                            class="btn btn-outline btn-warning btn-lg">{{ __('Cancel') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </form>

                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/custom/doctor-detail.js') }}"></script>
@endsection
