@extends('layouts.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @can('patient-drug-histories-create')
                        <h3>
                            <a href="{{ route('patient-drug-histories.create') }}" class="btn btn-outline btn-info">+
                                @lang('Add Patient Drug History')
                            </a>
                        </h3>
                    @endcan
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('Dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('Patient Drug List')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Patient Drug History List')</h3>
                    <div class="card-tools">
                        <a class="btn btn-primary float-right" target="_blank"
                            href="{{ route('patient-drug-histories.index') }}?export=1">
                            <i class="fas fa-cloud-download-alt"></i> @lang('Export')
                        </a>
                        <button class="btn btn-default" data-toggle="collapse" href="#filter">
                            <i class="fas fa-filter"></i> @lang('Filter')
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <div id="filter" class="collapse @if (request()->isFilterActive) show @endif">
                        <div class="card-body border">
                            <form action="" method="get" role="form" autocomplete="off">
                                <input type="hidden" name="isFilterActive" value="true">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>@lang('MRN Number')</label>
                                            <input type="text" name="mrn_number" class="form-control"
                                                value="{{ request()->mrn_number }}" placeholder="@lang('MRN Number')">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>@lang('Patient Name')</label>
                                            <input type="text" name="name" class="form-control"
                                                value="{{ request()->name }}" placeholder="@lang('Patient Name')">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 align-content-center">
                                        <button type="submit" class="btn btn-info mt-4">@lang('Submit')</button>
                                        @if (request()->isFilterActive)
                                            <a href="{{ route('patient-drug-histories.index') }}"
                                                class="btn btn-secondary mt-4">@lang('Clear')</a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <table class="table table-striped" id="laravel_datatable">
                        <thead>
                            <tr>

                                <th style="text-wrap:nowrap; min-width:110px;">@lang('MRN Number')</th>
                                <th>@lang('Patient Name')</th>
                                <th>@lang('Doctor Name')</th>
                                <th>@lang('Actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($patients as $patient)
                                <tr>
                                    <td><span>{{ $patient->patientDetails->mrn_number ?? 'N/A' }}</span></td>
                                    <td>{{ $patient->name }}</td>
                                    <td>
                                        @if ($patient->patientDrugHistories->isNotEmpty())
                                            {{ $patient->patientDrugHistories->first()->doctor->name ?? 'N/A' }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="responsive-width">
                                        @if ($patient->patientDrugHistories->isNotEmpty())
                                            <a href="{{ route('patient-drug-histories.show', $patient->patientDrugHistories->first()) }}"
                                                class="responsive-width-item btn btn-info btn-outline btn-circle btn-lg"
                                                data-toggle="tooltip" title="@lang('Show')">
                                                <i class="fa fa-eye ambitious-padding-btn"></i>
                                            </a>
                                        @endif
                                        @if ($patient->patientDrugHistories->isNotEmpty())
                                        @can('patient-drug-histories-update')
                                            <a href="{{ route('patient-drug-histories.edit', $patient->patientDrugHistories->first()) }}"
                                                class="responsive-width-item btn btn-info btn-outline btn-circle btn-lg"
                                                data-toggle="tooltip" title="@lang('Edit')">
                                                <i class="fa fa-edit ambitious-padding-btn"></i>
                                            </a>
                                        @endcan
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $patients->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
