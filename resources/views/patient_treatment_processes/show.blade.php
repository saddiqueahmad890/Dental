<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
@extends('layouts.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('patient-treatment-processes.index') }}">@lang('Patient Treatment Processes')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('Patient Treatment Process Details')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Patient Treatment Process Details')</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="process_id">@lang('Process ID')</label>
                                <p>{{ $patientTreatmentProcess->id }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="patient_treatment_plan_id">@lang('Patient Treatment Plan ID')</label>
                                <p>{{ $patientTreatmentProcess->patient_treatment_plan_id }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="comments">@lang('Comments')</label>
                                <p>{{ $patientTreatmentProcess->comments }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="process_started_at">@lang('Process Started At')</label>
                                <p>{{ $patientTreatmentProcess->process_started_at }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="process_completed_at">@lang('Process Completed At')</label>
                                <p>{{ $patientTreatmentProcess->process_completed_at }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="doctor_id">@lang('Doctor ID')</label>
                                <p>{{ $patientTreatmentProcess->doctor_id }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">@lang('Status')</label>
                                <p>{{ $patientTreatmentProcess->status }}</p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
