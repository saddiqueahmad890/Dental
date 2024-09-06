@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <a href="{{ route('patient-social-histories.index') }}" class="btn btn-outline btn-info">
                        <i class="fas fa-eye"></i> @lang('View All')
                    </a>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('patient-social-histories.index') }}">@lang('Social History')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('Add New Option')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Add New Social History')</h3>
                </div>
                <div class="card-body">
                    {{-- <form class="bg-custom" id="socialhistoryForm" action="{{ route('patient-social-histories.store') }}" method="POST">
                        @csrf
                        <div class="row col-12 m-0 p-0">
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label for="patient">@lang('Select Patient') <b class="ambitious-crimson">*</b></label>
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user-injured"></i></span>
                                        </div>
                                        <select name="patient"
                                            class="form-control select2 @error('patient') is-invalid @enderror"
                                            id="patient" required>
                                            <option value="">--@lang('Select')--</option>
                                            @foreach ($patients as $patient)
                                                <option value="{{ $patient->id }}"
                                                    {{ isset($selectedPatientId) && $selectedPatientId == $patient->id ? 'selected' : (old('patient') == $patient->id ? 'selected' : '') }}>
                                                    {{ $patient->name }} - {{ $patient->patientDetails->mrn_number ?? ' ' }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('patient')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="form-group">

                                    <?php
                                    $doctorId = '';
                                    if(auth()->user()->hasRole('Doctor')) {
                                        $doctorId = auth()->user()->id;
                                        ?>
                                    <input type="hidden" name="doctor" value="<?= $doctorId ?>" />
                                    <?php
                                    } else {
                                        ?>
                                    <label for="doctor">@lang('Select Doctor')</label>
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <select class="form-control select2 @error('doctor') is-invalid @enderror"
                                            id="doctor" name="doctor">
                                            <option value="">@lang('Select Doctor')</option>
                                            @foreach ($doctor as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                        <?php
                                    }
                                    ?>
                                        @error('doctor')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row col-12 m-0 p-0">
                            @foreach ($ddSocialHistory as $item)
                                <div class="col-xl-4">
                                    <div class="form-group m-0">
                                        <input type="checkbox" id="title_{{ $item->id }}"
                                            name="social_histories[{{ $item->id }}][checked]">
                                        <label for="title_{{ $item->id }}">{{ $item->title }}</label>
                                        <div class="form-group input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-plus-square"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="details_{{ $item->id }}"
                                                name="social_histories[{{ $item->id }}][comments]">
                                        </div>
                                        <input type="hidden" value="{{ $item->id }}"
                                            name="social_histories[{{ $item->id }}][title_id]">
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="row col-12 m-0 p-0">
                            <div class="col-xl-12">
                                <div class="form-group">
                                    <div class="col-md-8">
                                        <input type="submit" value="{{ __('Submit') }}"
                                            class="btn btn-outline btn-info btn-lg" />
                                        <a href="{{ route('patient-social-histories.index') }}"
                                            class="btn btn-outline btn-warning btn-lg">{{ __('Cancel') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form> --}}
                    <form class="bg-custom" id="socialhistoryForm" action="{{ route('patient-social-histories.store') }}" method="POST" data-parsley-validate>
                        @csrf

                        <div class="row col-12 m-0 p-0">
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label for="patient">@lang('Select Patient') <b class="ambitious-crimson">*</b></label>
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user-injured"></i></span>
                                        </div>
                                        <select name="patient"
                                            class="form-control select2 @error('patient') is-invalid @enderror"
                                            id="patient" required data-parsley-required="true"
                                            data-parsley-required-message="Please select patient." data-parsley-trigger="change">
                                            <option value="">--@lang('Select')--</option>
                                            @foreach ($patients as $patient)
                                                <option value="{{ $patient->id }}"
                                                    {{ isset($selectedPatientId) && $selectedPatientId == $patient->id ? 'selected' : (old('patient') == $patient->id ? 'selected' : '') }}>
                                                    {{ $patient->name }} - {{ $patient->patientDetails->mrn_number ?? ' ' }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('patient')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="form-group">
                                    <?php
                                    $doctorId = '';
                                    if(auth()->user()->hasRole('Doctor')) {
                                        $doctorId = auth()->user()->id;
                                        ?>
                                    <input type="hidden" name="doctor" value="<?= $doctorId ?>" />
                                    <?php
                                    } else {
                                        ?>
                                    <label for="doctor">@lang('Select Doctor')</label>
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <select class="form-control select2 @error('doctor') is-invalid @enderror"
                                            id="doctor" name="doctor" data-parsley-required="true"
                                            data-parsley-required-message="Please select doctor." data-parsley-trigger="change">
                                            <option value="">@lang('Select Doctor')</option>
                                            @foreach ($doctor as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                    @error('doctor')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row col-12 m-0 p-0">
                            @foreach ($ddSocialHistory as $item)
                                <div class="col-xl-4">
                                    <div class="form-group m-0">
                                        <input type="checkbox" id="title_{{ $item->id }}"
                                            name="social_histories[{{ $item->id }}][checked]" class="social-history-checkbox" data-parsley-multiple="social_histories" data-parsley-trigger="change">
                                        <label for="title_{{ $item->id }}">{{ $item->title }}</label>
                                        <div class="form-group input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-plus-square"></i></span>
                                            </div>
                                            <input type="text" class="form-control social-history-input" id="details_{{ $item->id }}"
                                                name="social_histories[{{ $item->id }}][comments]" data-parsley-required-if-checked="#title_{{ $item->id }}" data-parsley-trigger="change" disabled>
                                        </div>
                                        <input type="hidden" value="{{ $item->id }}"
                                            name="social_histories[{{ $item->id }}][title_id]">
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="row col-12 m-0 p-0">
                            <div class="col-xl-12">
                                <div class="form-group">
                                    <div class="col-md-8">
                                        <input type="submit" value="{{ __('Submit') }}"
                                            class="btn btn-outline btn-info btn-lg" />
                                        <a href="{{ route('patient-social-histories.index') }}"
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('input[type="text"]').prop('disabled', true);

            $('input[type="checkbox"]').change(function() {
                var inputBox = $(this).siblings('.input-group').find('input[type="text"]');

                if ($(this).is(':checked')) {
                    inputBox.prop('disabled', false);
                } else {
                    inputBox.prop('disabled', true);
                }
            });
        });
    </script>
@endsection
