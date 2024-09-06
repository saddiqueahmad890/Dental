@extends('layouts.layout')
@section('content')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @can('patient-appointment-create')
                        <h3>
                            <a href="{{ route('patient-treatment-processes.create') }}" class="btn btn-outline btn-info">+
                                @lang(' Patient Treatment Processes')</a>
                            <span class="pull-right"></span>
                        </h3>
                    @endcan
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item active">@lang('Patient Treatment Processes')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="card">
        <div class="card-header bg-info">
            <h3 class="card-title">@lang('List of Treatment Processes')</h3>
            <div class="card-tools">
                <button class="btn btn-default" data-toggle="collapse" href="#filter"><i class="fas fa-filter"></i>
                    @lang('Filter')</button>
            </div>
        </div>
        <div class="card-body p-0">
            <div id="filter" class="collapse @if (request()->isFilterActive) show @endif">
                <div class="card-body border">
                    <form action="" method="get" role="form" autocomplete="off">
                        <input type="hidden" name="isFilterActive" value="true">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>@lang('Name')</label>
                                    <input type="text" name="name" class="form-control" value="{{ request()->name }}"
                                        placeholder="@lang('Name')">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>@lang('MRN Number')</label>
                                    <input type="text" name="mrn_number" class="form-control"
                                        value="{{ request()->mrn_number }}" placeholder="@lang('mrn_number')">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>@lang('Email')</label>
                                    <input type="text" name="email" class="form-control" value="{{ request()->email }}"
                                        placeholder="@lang('Email')">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>@lang('Phone')</label>
                                    <input type="text" name="phone" class="form-control" value="{{ request()->phone }}"
                                        placeholder="@lang('Phone')">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-info">@lang('Submit')</button>
                                @if (request()->isFilterActive)
                                    <a href="{{ route('patient-details.index') }}"
                                        class="btn btn-secondary">@lang('Clear')</a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        
                        <th>@lang('Treatment Plan')</th>
                        <th>@lang('Comments')</th>
                        <th>@lang('Process Started At')</th>
                        <th>@lang('Process Completed At')</th>
                        <th>@lang('Doctor')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Actions')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($patientTreatmentProcesses as $process)
                        <tr>
                           
                            <td>{{ $process->treatmentPlan->comments ?? ' ' }}</td>
                            <td>{{ $process->comments }}</td>
                            <td>{{ $process->process_started_at }}</td>
                            <td>{{ $process->process_completed_at }}</td>
                            <td>{{ $process->doctor->name ?? ' ' }}</td>
                            <td>
                                @if ($process->status == 1)
                                    Active
                                @else
                                    Inactive
                                @endif
                            </td>
                            <td class="responsive-width">
                                <a href="{{ route('patient-treatment-processes.show', $process) }}"
                                    class="responsive-width-item btn btn-info btn-outline btn-circle btn-lg" data-toggle="tooltip"
                                    title="@lang('View')">
                                    <i class="fa fa-eye ambitious-padding-btn"></i>
                                </a>

                                @can('doctor-detail-update')
                                    <a href="{{ route('patient-treatment-processes.edit', $process) }}"
                                        class="responsive-width-item btn btn-info btn-outline btn-circle btn-lg" data-toggle="tooltip"
                                        title="@lang('Edit')">
                                        <i class="fa fa-edit ambitious-padding-btn"></i>
                                    </a>
                                @endcan

                                <a href="#" data-href="{{ route('patient-treatment-processes.destroy', $process) }}"
                                    class="responsive-width-item btn btn-info btn-outline btn-circle btn-lg" data-toggle="modal"
                                    data-target="#myModal" title="@lang('Delete')">
                                    <i class="fa fa-trash ambitious-padding-btn"></i>
                                </a>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $patientTreatmentProcesses->withQueryString()->links() }}
        </div>
    </div>
@endsection
