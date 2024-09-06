@extends('layouts.layout')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6 d-flex">
                <h3 class="mr-2">
                    <a href="{{ route('patient-treatment-processes.create') }}" class="btn btn-outline btn-info">+
                        @lang(' Patient Treatment Processes')</a>
                    <span class="pull-right"></span>
                </h3>
                <h3>
                    <a href="{{ route('patient-treatment-processes.index') }}" class="btn btn-outline btn-info"><i class="fas fa-eye"></i> @lang('View All')</a>

                </h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('patient-treatment-processes.index') }}">@lang('Treatment Process')</a>
                    </li>
                    <li class="breadcrumb-item active">@lang('Edit Process')</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info">
                <h3 class="card-title">@lang('Edit Treatment Process')</h3>
            </div>
            <div class="container-fluid p-0">
                <form id="treatmentprocessForm" action="{{ route('patient-treatment-processes.update', $patientTreatmentProcess->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label for="patient_treatment_plan_id">@lang('Treatment Plan')</label>
                                    <input type="text" name="patient_treatment_plan_id" class="form-control" value="{{ $patientTreatmentProcess->patient_treatment_plan_id }}" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="comments">@lang('Comments')</label>
                                    <textarea name="comments" class="form-control">{{ $patientTreatmentProcess->comments }}</textarea>
                                </div>
                                <div class="col-md-3">
                                    <label for="process_started_at">@lang('Process Started At')</label>
                                    <input type="datetime-local" name="process_started_at" class="form-control" value="{{ $patientTreatmentProcess->process_started_at }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="process_completed_at">@lang('Process Completed At')</label>
                                    <input type="datetime-local" name="process_completed_at" class="form-control" value="{{ $patientTreatmentProcess->process_completed_at }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label for="doctor_id">@lang('Doctor')</label>
                                    <input type="text" name="doctor_id" class="form-control" value="{{ $patientTreatmentProcess->doctor_id }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="status">@lang('Status')</label>
                                    <select name="status" class="form-control">
                                        <option value="1" {{ $patientTreatmentProcess->status == 1 ? 'selected' : '' }}>@lang('Active')</option>
                                        <option value="0" {{ $patientTreatmentProcess->status == 0 ? 'selected' : '' }}>@lang('Inactive')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-8">
                            <input type="submit" value="{{ __('Update') }}" class="btn btn-outline btn-info btn-lg"/>
                            <a href="{{ route('patient-treatment-processes.index') }}" class="btn btn-outline btn-warning btn-lg">{{ __('Cancel') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="container mt-5">
    <h2>User Logs</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>User</th>
                <th>Action</th>
                <th>Table</th>
                <th>Column</th>
                <th>Old Value</th>
                <th>New Value</th>
                <th>Timestamp</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logs as $log)
                <tr>
                    <td>{{ $log->user->id }}</td>
                    <td>{{ $log->action }}</td>
                    <td>{{ $log->table_name }}</td>
                    <td>{{ $log->field_name }}</td>
                    <td>{{ $log->old_value }}</td>
                    <td>{{ $log->new_value }}</td>
                    <td>{{ $log->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@push('footer')
    <script src="{{ asset('assets/js/custom/patient-treatment-process.js') }}"></script>
@endpush
