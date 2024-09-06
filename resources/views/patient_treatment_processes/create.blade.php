@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    {{-- <a href="{{ route('patient-treatment-processes.index') }}" class="btn btn-outline btn-info">
                        @lang('View All')
                    </a> --}}
                    <h3>
                        <a href="{{ route('patient-treatment-processes.index') }}" class="btn btn-outline btn-info"><i class="fas fa-eye"></i> @lang('View All')</a>

                    </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('patient-treatment-processes.index') }}">@lang('Treatment Process')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('Add New Process')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Add New Treatment Process')</h3>
                </div>
                <div class="card-body">
                    <form id="treatmentprocessForm" action="{{ route('patient-treatment-processes.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <label for="patient_treatment_plan_id">@lang('Treatment Plan')</label>
                                        <input type="text" name="patient_treatment_plan_id" class="form-control" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="comments">@lang('Comments')</label>
                                        <textarea name="comments" class="form-control"></textarea>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="process_started_at">@lang('Process Started At')</label>
                                        <input type="datetime-local" name="process_started_at" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="process_completed_at">@lang('Process Completed At')</label>
                                        <input type="datetime-local" name="process_completed_at" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="form-group">
                                <label for="doctor">@lang('Select Doctor')</label>
                                <select class="form-control @error('doctor') is-invalid @enderror" id="doctor" name="doctor">
                                    <option value="">@lang('Select Doctor')</option>
                                    @foreach($doctor as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('doctor')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                                    <div class="col-md-3">
                                        <label for="status">@lang('Status')</label>
                                        <select name="status" class="form-control">
                                            <option value="1">@lang('Active')</option>
                                            <option value="0">@lang('Inactive')</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-8">
                                        <input type="submit" value="{{ __('Submit') }}" class="btn btn-outline btn-info btn-lg" />
                                        <a href="{{ route('patient-treatment-processes.index') }}" class="btn btn-outline btn-warning btn-lg">{{ __('Cancel') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
