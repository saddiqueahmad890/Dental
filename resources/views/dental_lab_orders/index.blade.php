@extends('layouts.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                                        @can('lab-report-create')

                    <h3>
                        <a href="{{ route('dental_lab_orders.create') }}" class="btn btn-outline btn-info">
                            + @lang('Add Dental Lab Order')
                        </a>
                    </h3>
                    @endcan
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('Dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('Dental Lab Order List')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Dental Lab Order List')</h3>
                    <div class="card-tools">
                        <button class="btn btn-default" data-toggle="collapse" href="#filter">
                            <i class="fas fa-filter"></i> @lang('Filter')
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="filter" class="collapse @if (request()->has('isFilterActive')) show @endif">
                        <div class="card-body border">
                            <form action="{{ route('dental_lab_orders.index') }}" method="get">
                                <input type="hidden" name="isFilterActive" value="true">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>@lang('Doctor ID')</label>
                                            <input type="text" name="doctor_id" class="form-control"
                                                value="{{ request()->input('doctor_id') }}" placeholder="@lang('Doctor ID')">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>@lang('Patient ID')</label>
                                            <input type="text" name="patient_id" class="form-control"
                                                value="{{ request()->input('patient_id') }}"
                                                placeholder="@lang('Patient ID')">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <button type="submit" class="btn btn-info mt-4">@lang('Submit')</button>
                                        @if (request()->has('isFilterActive'))
                                            <a href="{{ route('dental_lab_orders.index') }}"
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
                                <th>@lang('Doctor')</th>
                                <th>@lang('Patient')</th>
                                <th>@lang('Sending Date')</th>
                                <th>@lang('Returning Date')</th>
                                <th>@lang('Time')</th>
                                <th>@lang('Actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->doctor->user->name ?? '-' }}</td>
                                    <td>{{ $order->patient->user->name ?? '-' }}</td>
                                    <td>{{ $order->sending_date ? \Carbon\Carbon::parse($order->sending_date)->format('Y-m-d') : '-' }}</td>
                                    <td>{{ $order->returning_date ? \Carbon\Carbon::parse($order->returning_date)->format('Y-m-d') : '-' }}</td>
                                    <td>{{ $order->time ?? '-' }}</td>
                                        @can('lab-report-read')

                                    <td>
                                        <a href="{{ route('dental_lab_orders.show', $order) }}"
                                            class="btn btn-info btn-outline btn-circle btn-lg" data-toggle="tooltip"
                                            title="@lang('View')"><i class="fa fa-eye"></i></a>
                                             @endcan
                                        @can('lab-report-update')

                                        <a href="{{ route('dental_lab_orders.edit', $order) }}"
                                            class="btn btn-info btn-outline btn-circle btn-lg" data-toggle="tooltip"
                                            title="@lang('Edit')"><i class="fa fa-edit"></i></a>
                                             @endcan
                                        @can('lab-report-delete')

                                        <a href="#" data-href="{{ route('dental_lab_orders.destroy', $order) }}"
                                            class="btn btn-info btn-outline btn-circle btn-lg" data-toggle="modal"
                                            data-target="#myModal" title="@lang('Delete')"><i class="fa fa-trash"></i></a>
                                             @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $orders->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>

    @include('layouts.delete_modal')
@endsection
