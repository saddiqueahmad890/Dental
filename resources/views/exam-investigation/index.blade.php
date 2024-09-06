@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @can('exam-investigations-create')
                        <h3><a href="{{ route('exam-investigations.create') }}" class="btn btn-outline btn-info">+
                                @lang('Add Patient Teeth Examination')</a>
                            <span class="pull-right"></span>
                        </h3>
                    @endcan
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('Dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('Existing Teeth Examinations List')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Existing Teeth Examinations List') </h3>
                    <div class="card-tools">
                        <a class="btn btn-primary float-right" target="_blank" href="{{ route('exam-investigations.index') }}?export=1"><i
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
                                    <div class="col-sm-6 col-md-6 col-lg-3">
                                        <div class="form-group">
                                            <label>@lang('Procedure Number')</label>
                                            <input type="text" name="pr_number" class="form-control"
                                                value="{{ request()->pr_number }}" placeholder="@lang(' Procedure Number')">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-3">
                                        <div class="form-group">
                                            <label>@lang('MRN Number')</label>
                                            <input type="text" name="mrn_number" class="form-control"
                                                value="{{ request()->mrn_number }}" placeholder="@lang('MRN Number')">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-3">
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


                                    <div class="col-sm-6 col-md-6 col-lg-3">
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
                                            <a href="{{ route('exam-investigations.index') }}"
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

                                <th>@lang('Examination Number')</th>
                                <th>@lang('MRN Number')</th>
                                <th>@lang('Patient')</th>
                                <th>@lang('Doctor')</th>
                                <th>@lang('Procedure Created')</th>
                                <th>@lang('Actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($examInvestigations as $examInvestigation)
                                <tr>

                                    <td><span style="text-wrap:nowrap">{{ $examInvestigation->examination_number }}</span></td>
                                    <td>{{ $examInvestigation->patient->patientDetails->mrn_number ?? '-'}}</td>
                                    <td>{{ isset($examInvestigation->patient->name) ? $examInvestigation->patient->name : '' }}
                                    </td>
                                    <td>{{ isset($examInvestigation->doctor->name) ? $examInvestigation->doctor->name : '' }}
                                    </td>
                                    <td>{{ $examInvestigation->created_at->format('d-m-Y') }}</td>

                                    <td class="responsive-width">
                                        <a href="{{ route('exam-investigations.show', $examInvestigation) }}"
                                            class="responsive-width-item btn btn-info btn-outline btn-circle btn-lg"
                                            data-toggle="tooltip" title="@lang('View')">
                                            <i class="fa fa-eye ambitious-padding-btn"></i>
                                        </a>

                                        @can('exam-investigations-update')
                                        <a href="{{ route('exam-investigations.edit', $examInvestigation) }}"
                                            class="responsive-width-item btn btn-info btn-outline btn-circle btn-lg" data-toggle="tooltip"
                                            title="@lang('Edit')"><i class="fa fa-edit ambitious-padding-btn"></i>
                                        </a>
                                        @endcan

                                        @can('exam-investigations-delete')
                                        <a href="#" data-href="{{ route('exam-investigations.destroy', $examInvestigation) }}"
                                            class="responsive-width-item btn btn-info btn-outline btn-circle btn-lg" data-toggle="modal" data-target="#myModal"
                                            title="@lang('Delete')"><i class="fa fa-trash ambitious-padding-btn"></i>
                                        </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $examInvestigations->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('layouts.delete_modal')
@endsection
