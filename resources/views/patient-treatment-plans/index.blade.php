@extends('layouts.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @can('patient-treatment-plans-create')
                        <h3>
                            <a href="{{ route('patient-treatment-plans.create') }}" class="btn btn-outline btn-info">+
                                @lang('Add New Plan')</a>
                            <span class="pull-right"></span>
                        </h3>
                    @endcan
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item active">@lang('Treatment Plans')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="card">

        <div class="card">
            <div class="card-header bg-info">
                <h3 class="card-title">@lang('Treatment Plans')</h3>

                <div class="card-tools">
                     <a class="btn btn-primary float-right" target="_blank" href="{{ route('patient-treatment-plans.index') }}?export=1"><i
                                class="fas fa-cloud-download-alt"></i> @lang('Export')</a>
                    <button class="btn btn-default" data-toggle="collapse" href="#filter"><i class="fas fa-filter"></i>
                        @lang('Filter')</button>
                </div>
            </div>
            <div class="card-body table-responsive">
                <div id="filter" class="collapse @if (request()->isFilterActive) show @endif">
                    <div class="card-body border">
                        <form action="" method="get" role="form" autocomplete="off">
                            <input type="hidden" name="isFilterActive" value="true">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>@lang('MRN Number')</label>
                                        <input type="text" name="mrn_number" class="form-control"
                                            value="{{ request()->mrn_number }}" placeholder="@lang('mrn_number')">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>@lang('Patient Name')</label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ request()->name }}" placeholder="@lang('Patient Name')">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>@lang('Examination Number')</label>
                                        <input type="text" name="examination_number" class="form-control"
                                            value="{{ request()->examination_number }}" placeholder="@lang('Examination Number')">
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-info">@lang('Submit')</button>
                                    @if (request()->isFilterActive)
                                        <a href="{{ route('patient-treatment-plans.index') }}"
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

                            <th>@lang("Treatment Plan's")</th>
                            {{-- <th style="text-wrap:nowrap; min-width:110px;">@lang('MRN Number')</th> --}}
                            <th style="text-wrap:nowrap;">Examination No</th>
                            
                            <th>@lang("Patient's")</th>
                            <th>@lang("Doctor's")</th>

                            <th>@lang('Actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($patientTreatmentPlans as $patientTreatmentPlan)
                            <tr style="min-height:100px">


                                <td><span>{{ $patientTreatmentPlan->treatment_plan_number ?? ' ' }}</span></td>
                                <td>{{ $patientTreatmentPlan->examinvestigation->examination_number ?? ' ' }}</td>
                                <td>{{ $patientTreatmentPlan->patient->name ?? ' ' }}</td>
                                <td>{{ $patientTreatmentPlan->doctor->name ?? ' ' }}</td>
                                {{-- <td>{{ $patientTreatmentPlan->id ?? ' ' }}</td> --}}

                                <td class="responsive-width">

                                    <a href="{{ route('patient-treatment-plans.show', $patientTreatmentPlan->id) }}"
                                        class="responsive-width-item btn btn-info btn-outline btn-circle btn-lg"
                                        data-toggle="tooltip" title="@lang('View')">
                                        <i class="fa fa-eye ambitious-padding-btn"></i>
                                    </a>

                                    @can('patient-treatment-plans-update')
                                    <a href="{{ route('patient-treatment-plans.edit', $patientTreatmentPlan->id) }}"
                                        class="responsive-width-item btn btn-info btn-outline btn-circle btn-lg"
                                        data-toggle="tooltip" title="@lang('Edit')">
                                        <i class="fa fa-edit ambitious-padding-btn"></i>
                                    </a>
                                    @endcan

                                    @can('patient-treatment-plans-delete')
                                    <a href="#"
                                        data-href="{{ route('patient-treatment-plans.destroy', $patientTreatmentPlan) }}"
                                        class="responsive-width-item btn btn-info btn-outline btn-circle btn-lg"
                                        data-toggle="modal" data-target="#myModal" title="@lang('Delete')">
                                        <i class="fa fa-trash ambitious-padding-btn"></i>
                                    </a>
                                    @endcan
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $patientTreatmentPlans->withQueryString()->links() }}

            </div>
        </div>
    </div>
    @include('layouts.delete_modal')
@endsection
