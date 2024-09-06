@extends('layouts.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>
                        <a href="{{ route('medical-history.create') }}" class="btn btn-outline btn-info">
                            + @lang('Add Medical History')
                        </a>
                        <span class="pull-right"></span>
                    </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('Dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('Medical History')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Medical History List')</h3>
                    <div class="card-tools">
                        <!-- <a class="btn btn-primary" target="_blank" href="{{ route('medical-history.index') }}?export=1"> -->
                            <i class="fas fa-cloud-download-alt"></i> @lang('Export')
                        </a>
                        <button class="btn btn-default" data-toggle="collapse" href="#filter">
                            <i class="fas fa-filter"></i> @lang('Filter')
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="laravel_datatable">
                        <thead>
                            <tr>
                                <th>@lang('Doctor Name')</th>
                                <th>@lang('Patient Name')</th>
                                <th>@lang('Actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($medicalRecords as $record)
                                <tr>
                                    <td>{{ $record['doctor_name'] }}</td>
                                    <td>{{ $record['patient_name'] }}</td>
                                    <td>
                                        <a href="{{ route('medical-history', ['doctor_id' => $record['doctor_id'], 'patient_id' => $record['patient_id']]) }}" class="btn btn-info btn-outline btn-circle btn-lg" data-toggle="tooltip" title="@lang('Edit')">
                                            <i class="fa fa-edit ambitious-padding-btn"></i>
                                        </a>
                                        <!-- Add other actions as needed -->
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.delete_modal')

@endsection
