@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @can('patient-detail-create')
                        <h3><a href="{{ route('teeth-procedures.create') }}" class="btn btn-outline btn-info">+
                                @lang('Add Patient Teeth Procedure')</a>
                            <span class="pull-right"></span>
                        </h3>
                    @endcan
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('Dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('Existing Procedures List')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Existing Procedures List') </h3>
                    <div class="card-tools">
                        <a class="btn btn-primary" target="_blank" href="{{ route('teeth-procedures.index') }}?export=1"><i
                                class="fas fa-cloud-download-alt"></i> @lang('Export')</a>
                        <button class="btn btn-default" data-toggle="collapse" href="#filter"><i class="fas fa-filter"></i>
                            @lang('Filter')</button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="filter" class="collapse @if (request()->isFilterActive) show @endif">
                        <div class="card-body border">
                            <form action="" method="get" role="form" autocomplete="off">
                                <input type="hidden" name="isFilterActive" value="true">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>@lang('Procedure Number')</label>
                                            <input type="text" name="pr_number" class="form-control"
                                                value="{{ request()->pr_number }}" placeholder="@lang(' Procedure Number')">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>@lang('MRN Number')</label>
                                            <input type="text" name="mrn_number" class="form-control"
                                                value="{{ request()->mrn_number }}" placeholder="@lang('MRN Number')">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>@lang('Patient')</label>
                                            <select name="patient_id" class="form-control select2">
                                                <option value="">@lang('Select Patient')</option>
                                                @foreach ($patients as $patient)
                                                    <option value="{{ $patient->id }}"
                                                        {{ request()->patient_id == $patient->id ? 'selected' : '' }}>
                                                        {{ $patient->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>@lang('Doctor')</label>
                                            <select name="doctor_id" class="form-control select2" >
                                                <option value="">@lang('Select Doctor')</option>
                                                @foreach ($doctors as $doctor)
                                                    <option value="{{ $doctor->id }}"
                                                        {{ request()->doctor_id == $doctor->id ? 'selected' : '' }}>
                                                        {{ $doctor->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-info">@lang('Submit')</button>
                                        @if (request()->isFilterActive)
                                            <a href="{{ route('teeth-procedures.index') }}"
                                                class="btn btn-secondary">@lang('Clear')</a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <table class="table table-striped" id="laravel_datatable">
                        <thead>
                            <tr>

                                <th>@lang('Procedure Number')</th>
                                <th>@lang('MRN Number')</th>
                                <th>@lang('Patient')</th>
                                <th>@lang('Doctor')</th>
                                <th>@lang('Procedure Created')</th>
                                <th>@lang('Actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($teethProcedures as $teethProcedure)
                                <tr>

                                    <td>{{ $teethProcedure->pr_number }}</td>
                                    <td>{{ $teethProcedure->patient->patientDetails->mrn_number ??'-' }}</td>
                                    <td>{{ isset($teethProcedure->patient->name) ? $teethProcedure->patient->name : '' }}
                                    </td>
                                    <td>{{ isset($teethProcedure->doctor->name) ? $teethProcedure->doctor->name : '' }}
                                    </td>
                                    <td>{{ $teethProcedure->created_at->format('d-m-Y') }}</td>

                                    <td>
                                        <a href="{{ route('teeth-procedures.edit', $teethProcedure) }}"
                                            class="btn btn-info btn-outline btn-circle btn-lg" data-toggle="tooltip"
                                            title="@lang('Edit')"><i
                                                class="fa fa-edit ambitious-padding-btn"></i></a>&nbsp;&nbsp;
                                        <a href="#"
                                            data-href="{{ route('teeth-procedures.destroy', $teethProcedure) }}"
                                            class="btn btn-info btn-outline btn-circle btn-lg" data-toggle="modal"
                                            data-target="#myModal" title="@lang('Delete')"><i
                                                class="fa fa-trash ambitious-padding-btn"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $teethProcedures->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('layouts.delete_modal')
@endsection
