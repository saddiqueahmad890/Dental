@extends('layouts.layout')
@section('content')
    <style>
        h6 {
            font-size: 0.8rem !important;
        }

        th {
            font-size: 14px;
        }

        td {
            font-size: 12px;
        }
    </style>


    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('invoices.index') }}">@lang('Invoice')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('Invoice Info')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Invoice Info')</h3>
                    <div class="card-tools">
                        <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-info">@lang('Edit')</a>
                        <button id="doPrint" class="btn btn-default"><i class="fas fa-print"></i> Print</button>
                    </div>
                </div>
                <div id="print-area" class="card-body">
                    <div class="row" style="position:relative;">
                        <h4 style="position: absolute; top:30px; left: 45%;">Invoice</h4>
                    </div>
                    <div class="row ">
                        <div class="col-12">
                            <h4 class="pb-3"><img src="{{ asset('assets/images/logo.png') }}"
                                    alt="{{ $ApplicationSetting->item_name }}" id="custom-opacity-sidebar"
                                    class="brand-image">{{ $ApplicationSetting->item_name }}</h4>
                        </div>
                    </div>

                    <div class="row col-12 p-0 m-0">
                        <div class="col-4">
                            <h6 class="size">{{ $ApplicationSetting->company_address }}</h6>
                        </div>
                        <div class="col-8 text-right">
                            <h6 class="size">Patient: {{ $invoice->user->name }}</h6>
                        </div>

                    </div>

                    <div class="row col-12 p-0 m-0">

                        <div class="col-4">
                            <h6 class="size">Email: {{ $ApplicationSetting->company_email }}</h6>
                        </div>
                        <div class="col-8 text-right">
                            <h6 class="size">@lang('Phone'): {{ $invoice->user->phone }}</h6>
                        </div>

                    </div>
                    <div class="row col-12 p-0 m-0">

                        <div class="col-4">
                            <h6 class="size">Phone: {{ $ApplicationSetting->contact }}</h6>
                        </div>
                        <div class="col-8 text-right">
                            <h6 class="size">MRN no: {{ $invoice->user->patientDetails->mrn_number ?? '' }}</h6>
                        </div>

                    </div>
                    <div class="row col-12 p-0 m-0">

                        <div class="col-4">
                            <h6 class="size">@lang('Invoice') no: {{ str_pad($invoice->id, 4, '0', STR_PAD_LEFT) }}</h6>
                        </div>
                        <div class="col-8 text-right">
                            <h6 class="size">
                                @lang('Date'):
                                {{ date($companySettings->date_format ?? 'Y-m-d', strtotime($invoice->invoice_date)) }}
                                <br></h6>
                        </div>

                    </div>

                    <hr class="pb-3">









                    <div class="row col-12 p-0 m-0">
                        <div class="col-12 table-responsive p-0 m-0">
                            <table class="table custom-table">
                                <thead>
                                    <tr>
                                        <th scope="col" style="color:black; border:1px solid #17a2b8;" class="col-3">
                                            @lang('Procedure')</th>
                                        <th scope="col" style="color:black; border:1px solid #17a2b8;"class="col-5">
                                            @lang('Description')</th>
                                        <th scope="col"style="color:black; border:1px solid #17a2b8;" class="col-1">
                                            @lang('Quantity')</th>
                                        <th scope="col"style="color:black; border:1px solid #17a2b8;" class="col-1">
                                            @lang('Price')</th>
                                        <th scope="col" style="color:black; border:1px solid #17a2b8;"class="col-2">
                                            @lang('Sub Total')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invoice->invoiceItems as $invoiceItem)
                                        <tr>
                                            @if ($invoiceItem->patient_treatment_plan_procedure_id)
                                                <td style="border: 1px solid #17a2b8;">
                                                    {{ $invoiceItem->patienttreatmentplanprocedures->procedure->title ?? '-' }}
                                                </td>
                                            @else
                                                <td style="border: 1px solid #17a2b8;">{{ $invoiceItem->title }}</td>
                                            @endif
                                            <td style="border: 1px solid #17a2b8;">{{ $invoiceItem->description }}</td>
                                            <td style="border: 1px solid #17a2b8;">{{ $invoiceItem->quantity }}</td>
                                            <td style="border: 1px solid #17a2b8;">{{ $invoiceItem->price }}</td>
                                            <td style="border: 1px solid #17a2b8;">{{ $invoiceItem->total }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row col-12 p-0 m-0">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 offset-6">
                            <p class="lead">@lang('Insurance'): {{ $invoice->insurance->name ?? 'N/A' }}</p>
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>@lang('Total')</th>
                                            <td>{{ $invoice->total }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('Discount') ({{ $invoice->discount_percentage }}%)</th>
                                            <td>{{ $invoice->total_discount }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('Vat') ({{ $invoice->vat_percentage }}%)</th>
                                            <td>{{ $invoice->total_vat }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('Grand Total')</th>
                                            <td>{{ $invoice->grand_total }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('Paid')</th>
                                            <td>{{ $invoice->paid }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('Due')</th>
                                            <td>{{ $invoice->due }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row col-6 offset-6">
                        <p class="pl-1">
                            This document is created by {{ $invoice->creator->name ?? '-' }} at
                            {{ $invoice->created_at ?? '-' }}
                            and printed by {{ Auth::user()->name }} at {{ now()->format('Y-m-d H:i:s') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
@endsection
