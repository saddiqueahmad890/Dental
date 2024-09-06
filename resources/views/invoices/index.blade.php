@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @can('invoice-create')
                        <h3><a href="{{ route('invoices.create') }}" class="btn btn-outline btn-info">+ @lang('Invoice')</a>
                            <span class="pull-right"></span>
                        </h3>
                    @endcan
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item active">@lang('Invoice')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Invoice List')</h3>
                    <div class="card-tools">
                        <button class="btn btn-default" data-toggle="collapse" href="#filter"><i class="fas fa-filter"></i> @lang('Filter')</button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="filter" class="collapse @if(request()->isFilterActive) show @endif">
                        <div class="card-body border">
                            <form action="" method="get" role="form" autocomplete="off">
                                <input type="hidden" name="isFilterActive" value="true">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>@lang('Patient')</label>
                                            <select name="user_id" class="form-control select2" id="user_id">
                                                <option value="">--@lang('Select')--</option>
                                                @foreach ($patients as $patient)
                                                    <option value="{{ $patient->id }}" {{ old('user_id', request()->user_id) == $patient->id ? 'selected' : '' }}>{{ $patient->id . '. ' . $patient->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>@lang('Doctor')</label>
                                            <select name="doctor_id" class="form-control select2" id="doctor_id">
                                                <option value="">--@lang('Select')--</option>
                                                @foreach ($doctors as $doctor)
                                                    <option value="{{ $doctor->id }}" {{ old('doctor_id', request()->doctor_id) == $doctor->id ? 'selected' : '' }}>{{ $doctor->id . '. ' . $doctor->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>@lang('Invoice Number')</label>
                                            <input type="text" name="invoice_number" id="invoice_number" class="form-control" placeholder="@lang('Invoice Number')" value="{{ old('invoice_number', request()->invoice_number) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>@lang('Invoice Date')</label>
                                            <input type="text" name="invoice_date" id="invoice_date" class="form-control flatpickr" placeholder="@lang('Invoice Date')" value="{{ old('invoice_date', request()->invoice_date) }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>@lang('Start Date')</label>
                                            <input type="text" name="start_date" id="start_date" class="form-control flatpickr" placeholder="@lang('Start Date')" value="{{ old('start_date', request()->start_date) }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>@lang('End Date')</label>
                                            <input type="text" name="end_date" id="end_date" class="form-control flatpickr" placeholder="@lang('End Date')" value="{{ old('end_date', request()->end_date) }}">
                                        </div>
                                    </div>


                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <button type="submit" class="btn btn-info">@lang('Submit')</button>
                                        @if(request()->isFilterActive)
                                            <a href="{{ route('invoices.index') }}" class="btn btn-secondary">@lang('Clear')</a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>


                    <table class="table table-striped" id="laravel_datatable">
                        <thead>
                            <tr>

                                <th>@lang('Invoice Number')</th>
                                <th>@lang('Patient Name')</th>
                                <th>@lang('Doctor Name')</th>
                                <th>@lang('Date')</th>
                                <th>@lang('Grand Total')</th>
                                <th>@lang('Paid')</th>
                                <th>@lang('Due')</th>
                                <th>@lang('Actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $invoice)
                                <tr>
                                    <td><span style="text-wrap:nowrap;">{{ $invoice->invoice_number ?? '-' }}</span></td>
                                    <td>{{ $invoice->user->name ??'-'}}</td>
                                     @if($invoice->patient_treatment_plan_id)
                                    <td>{{ isset($invoice->patienttreatmentplan->doctor->name) ? $invoice->patienttreatmentplan->doctor->name :"-"}}</td>
                                    @else
                                    <td>{{ isset($invoice->doctor->name) ? $invoice->doctor->name :"-"}}</td>
                                    @endif
                                    <td> {{ date($companySettings->date_format ?? 'Y-m-d', strtotime($invoice->invoice_date)) }}</td>
                                    <td>{{ $invoice->grand_total }}</td>
                                    <td>{{ $invoice->paid}}</td>
                                    <td>{{ $invoice->due }}</td>
                                    <td class="responsive-width">
                                        <a href="{{ route('invoices.show', $invoice) }}" class="responsive-width-item btn btn-info btn-outline btn-circle btn-lg" data-toggle="tooltip" title="@lang('View')"><i class="fa fa-eye ambitious-padding-btn"></i></a>
                                        @can('invoice-update')
                                            <a href="{{ route('invoices.edit', $invoice) }}" class="responsive-width-item btn btn-info btn-outline btn-circle btn-lg" data-toggle="tooltip" title="@lang('Edit')"><i class="fa fa-edit ambitious-padding-btn"></i></a>
                                        @endcan
                                        @can('invoice-delete')
                                            <a href="#" data-href="{{ route('invoices.destroy', $invoice) }}" class="responsive-width-item btn btn-info btn-outline btn-circle btn-lg" data-toggle="modal" data-target="#myModal" title="@lang('Delete')"><i class="fa fa-trash ambitious-padding-btn"></i></a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4">@lang('Total')</th>
                                <th>{{ $totalGrandTotal }}</th>
                                <th>{{ $totalPaid }}</th>
                                <th>{{ $totalDue }}</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                    {{ $invoices->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@include('layouts.delete_modal')
@endsection
