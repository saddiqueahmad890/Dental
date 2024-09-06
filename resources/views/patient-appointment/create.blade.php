@extends('layouts.layout')
@section('content')
    <style>
/* Flash message styles */
.custom-flash-message {
    position: fixed;
    top: 10px;
    right: 10px;
    padding: 10px 20px;
    border-radius: 5px;
    color: #fff;
    font-size: 14px;
    z-index: 9999;
    display: none; /* Ensure initial display is none */
}

.custom-flash-message.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
}

.custom-flash-message.alert-success {
    background-color: #d4edda;
    color: #155724;
}


    </style>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3>
                        <a href="{{ route('patient-appointments.index') }}" class="btn btn-outline btn-info"><i
                                class="fas fa-eye"></i> @lang('View All')</a>

                    </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('patient-appointments.index') }}">@lang('Patient Appointment')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('Add Patient Appointment')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Add Patient Appointment')</h3>
                </div>
                <div class="col-md-3" id="doctor_availability">
                    <!-- Flash message for doctor's availability will be displayed here -->
                </div>
                <div class="card-body">
                    <form class="bg-custom" id="scheduleForm" class="form-material form-horizontal"
                        action="{{ route('patient-appointments.store') }}" method="POST" enctype="multipart/form-data"
                        data-parsley-validate>
                        @csrf
                        <div class="row col-12 m-0 p-0">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="user_id">@lang('Select Patient') <b class="ambitious-crimson">*</b></label>
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user-injured"></i></span>
                                        </div>
                                        <select name="user_id"
                                            class="form-control select2 @error('user_id') is-invalid @enderror"
                                            id="user_id" required data-parsley-required="true"
                                            data-parsley-required-message="Please select patient."
                                            data-parsley-trigger="change">
                                            <option value="">--@lang('Select')--</option>
                                            @foreach ($patients as $patient)
                                                <option value="{{ $patient->id }}"
                                                    {{ (isset($selectedPatientId) && $selectedPatientId == $patient->id) || old('user_id') == $patient->id ? 'selected' : '' }}>
                                                    {{ $patient->name }} -
                                                    {{ $patient->patientDetails->mrn_number ?? 'N/A' }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('user_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="doctor_id">@lang('Select Doctor') <b class="ambitious-crimson">*</b></label>
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user-md"></i></span>
                                        </div>
                                        <select name="doctor_id"
                                            class="form-control select2 @error('doctor_id') is-invalid @enderror"
                                            id="doctor_id" required data-parsley-required="true"
                                            data-parsley-required-message="Please select doctor."
                                            data-parsley-trigger="change">
                                            <option value="">--@lang('Select')--</option>
                                            @foreach ($doctors as $doctor)
                                                <option value="{{ $doctor->id }}"
                                                    {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                                    {{ $doctor->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('doctor_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="appointment_date">@lang('Appointment Date') <b
                                            class="ambitious-crimson">*</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-check"></i></span>
                                        </div>
                                        <input type="date" name="appointment_date" id="appointment_date"
                                            class="form-control flatpickr @error('appointment_date') is-invalid @enderror"
                                            placeholder="@lang('Appointment Date')" value="{{ old('appointment_date') }}" required
                                            data-parsley-required="true"
                                            data-parsley-required-message="Please select appointment date" data-parsley-trigger="change">
                                        @error('appointment_date')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row col-12 m-0 p-0">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="start_time">@lang('Start Time') <b class="ambitious-crimson">*</b></label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-clock"></i></span>
                                            </div>
                                            <input type="time" name="start_time" id="start_time" class="form-control @error('start_time') is-invalid @enderror" value="{{ old('start_time') }}" required>
                                            @error('start_time')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="end_time">@lang('End Time') <b class="ambitious-crimson">*</b></label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-clock"></i></span>
                                            </div>
                                            <input type="time" name="end_time" id="end_time" class="form-control @error('end_time') is-invalid @enderror" value="{{ old('end_time') }}" required>
                                            @error('end_time')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row col-12 m-0 p-0">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="problem">@lang('Problem')</label>
                                    <div class="input-group mb-3">
                                        <textarea name="problem" id="problem" class="form-control @error('problem') is-invalid @enderror" rows="4"
                                            placeholder="@lang('Problem')">{{ old('problem') }}</textarea>
                                        @error('problem')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-12 m-0 p-0 mb-3">
                            <label class="col-md-3 col-form-label"></label>
                            <div class="col-md-8">
                                <input type="submit" value="{{ __('Submit') }}"
                                    class="btn btn-outline btn-info btn-lg" />
                                <a href="{{ route('patient-appointments.index') }}"
                                    class="btn btn-outline btn-warning btn-lg">{{ __('Cancel') }}</a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer')
    <script src="{{ asset('assets/js/custom/patient-appointment.js') }}"></script>
@endpush
