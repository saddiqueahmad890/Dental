@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3>
                        <a href="{{ route('patient-medical-histories.index') }}" class="btn btn-outline btn-info">
                            <i class="fas fa-eye"></i> @lang('View All')
                        </a>
                    </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('patient-medical-histories.index') }}">@lang('Medical History')</a>
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
                    <h3 class="card-title">@lang('Add New Medical History')</h3>
                </div>
                <div class="card-body">

                    <form id="medicalhistoryForm" class="bg-custom" action="{{ route('patient-medical-histories.store') }}" method="POST" data-parsley-validate>
                        @csrf
                        <div class="row col-12 p-0 m-0">
                            <div class="col-md-6">
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
                            <div class="col-md-6">
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
                        <div class="row col-12 p-0 m-0">
                            @foreach ($ddMedicalHistory as $item)
                                <div class="col-xl-3 p-3">
                                    <div class="form-group m-0">
                                        <input type="checkbox" id="title_{{ $item->id }}"
                                            name="medical_histories[{{ $item->id }}][checked]"
                                            class="medical-history-checkbox" data-parsley-multiple="medical_histories">
                                        <label for="title_{{ $item->id }}">{{ $item->title }}</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-solid fa-plus-square"></i></span>
                                            </div>
                                            <input type="text" class="form-control medical-history-input" id="details_{{ $item->id }}"
                                                name="medical_histories[{{ $item->id }}][comments]" data-parsley-required-if-checked="title_{{ $item->id }}">
                                        </div>
                                        <input type="hidden" value="{{ $item->id }}"
                                            name="medical_histories[{{ $item->id }}][title_id]">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="row col-12 p-0 m-0">
                            <div class="col-xl-12">
                                <div class="form-group">
                                    <div class="col-md-8">
                                        <input type="submit" value="{{ __('Submit') }}"
                                            class="btn btn-outline btn-info btn-lg" />
                                        <a href="{{ route('patient-medical-histories.index') }}"
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

            $('input.medical-history-input').prop('disabled', true);

            $('input.medical-history-checkbox').change(function() {

                var inputBox = $(this).closest('.form-group').find('input.medical-history-input');
                if ($(this).is(':checked')) {
                    inputBox.prop('disabled', false);
                } else {
                    inputBox.prop('disabled', true);
                }
            });
        });
    </script>
@endsection
