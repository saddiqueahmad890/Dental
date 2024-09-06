@extends('layouts.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <a href="{{ route('patient-treatment-plans.index') }}" class="btn btn-outline btn-info">
                        @lang('View All')</a>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a
                                href="{{ route('patient-treatment-plans.index') }}">@lang('Treatment Plans')</a></li>
                        <li class="breadcrumb-item active">@lang('Add New Plan')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="row treatment-plan-row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Add New Treatment Plan')</h3>
                </div>
                <div class="card-body">
                    <form class="bg-custom" action="{{ route('patient-treatment-plans.store') }}" method="POST" data-parsley-validate>
                        @csrf
                        <div class="row col-12 m-0 p-0">
                            <div class="col-xl-12">
                                <div class="form-group row">
                                    <!-- Patient Field -->
                                    @if (isset($examinationData))
                                        <div class="col-md-4">
                                            <label for="patient">@lang('Patient')</label>
                                            <input type="text" class="form-control" value="{{ $examinationData->patient->name }}" readonly>
                                            <input type="hidden" name="patient_id" value="{{ $examinationData->patient_id }}">
                                        </div>
                                    @else
                                        <div class="col-md-4">
                                            <label for="patient_id">@lang('Select Patient')</label>
                                            <div class="form-group input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-user-injured"></i></span>
                                                </div>
                                                <select class="form-control @error('patient_id') is-invalid @enderror"
                                                        id="patient_id" name="patient_id" required data-parsley-required="true"
                                                        data-parsley-required-message="Please select patient." data-parsley-trigger="change">
                                                    <option value="">@lang('Select Patient')</option>
                                                    @foreach ($patients as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->patientDetails->mrn_number ?? ' ' }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('patient_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    @endif

                                    <!-- Examination Field -->
                                    @if (isset($examinationData))
                                        <div class="col-md-4">
                                            <label for="examination_id">@lang('Examination')</label>
                                            <input type="text" class="form-control"
                                                   value="{{ $examinationData->examination_number ?? ' ' }}"
                                                   readonly>
                                            <input type="hidden" name="examination_id" value="{{ $examinationData->id }}">
                                        </div>
                                    @else
                                        <div class="col-md-4">
                                            <label for="examination_id">@lang('Select Examination')</label>
                                            <div class="form-group input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-plus-square"></i></span>
                                                </div>
                                                <select class="form-control @error('examination_id') is-invalid @enderror"
                                                        id="examination_id" name="examination_id" required data-parsley-required="true"
                                                        data-parsley-required-message="Please select examination" data-parsley-trigger="change">
                                                    <option value="">@lang('Select Teeth Examination')</option>

                                                </select>
                                            </div>
                                            @error('examination_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    @endif

                                    <!-- Doctor Field -->
                                    @if (isset($examinationData))
                                        <div class="col-md-4">
                                            <label for="doctor_id">@lang('Doctor')</label>
                                            <input type="text" class="form-control"
                                                   value="{{ $examinationData->doctor->name }}"
                                                   readonly>
                                            <input type="hidden" name="doctor_id" value="{{ $examinationData->doctor_id }}">
                                        </div>
                                    @else
                                        <div class="col-md-4">
                                            <label for="doctor_id">@lang('Select Doctor')</label>
                                            <div class="form-group input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                </div>
                                                <select class="form-control @error('doctor_id') is-invalid @enderror"
                                                        id="doctor_id" name="doctor_id" required data-parsley-required="true"
                                                        data-parsley-required-message="Please select doctor." data-parsley-trigger="change">
                                                    <option value="">@lang('Select Doctor')</option>

                                                </select>
                                            </div>
                                            @error('doctor_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    @endif
                                </div>

                                <!-- Comments and Status -->
                                <div class="form-group row">
                                    <div class="col-md-8">
                                        <label for="comments">@lang('Comments')</label>
                                       <div class="form-group input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-file"></i></span>
                                            </div>
                                            <textarea rows="1" name="comments" class="form-control"></textarea>
                                       </div>
                                    </div>

                                </div>

                                <!-- Submit and Cancel -->
                                <div class="row mb-2">
                                    <div class="col-md-12">
                                        <input type="submit" value="{{ __('Submit') }}"
                                            class="btn btn-outline btn-info btn-lg" />
                                        <a href="{{ route('patient-treatment-plans.index') }}"
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
    </div>



<script>
    $(document).ready(function(){

        $('#patient_id').on('change', function() {
            var patientId = $(this).val();
            $('#tooth_id').html('');
            $.ajax({
                url: '{{ route("fetch.procedures") }}',
                type: 'GET',
                data: { patient_id: patientId },
                success: function(data) {
                    var procedures = data.procedures;
                    var options = '<option value="" disabled selected>Select Examination</option>';
                    $.each(procedures, function(index, procedure) {
                        options += '<option value="' + procedure.id + '">' + procedure.examination_number + '</option>';
                    });
                    $('#examination_id').html(options);
                },
                error: function(xhr, status, error) {
                    alert('Failed to fetch Teeth Procedures! Please try again.');
                }
            });
        });

        $('#examination_id').on('change', function() {
            var examinationId = $(this).val();
            $.ajax({
                url: '{{ route("fetch.teeth") }}',
                type: 'GET',
                data: { examination_id: examinationId },
                success: function(data) {
                    var doctor = data.doctorDetails;
                    doctor_value = '<option value="' + doctor.id + '">' + doctor.name + '</option>';
                    $('#doctor_id').html(doctor_value);
                },
                error: function(xhr, status, error) {
                    alert('Failed to fetch Doctor! Please try again.');
                }
            });
        });
    });
</script>
@endsection
