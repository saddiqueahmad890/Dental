@extends('layouts.layout')
<style>
    .table td,
    .table th {
        padding: 0.4rem !important;
    }

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
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('prescriptions.index') }}">@lang('Prescription')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('Prescription Info')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Prescription Info')</h3>
                    <div class="card-tools">
                        @can('prescription-update')
                            <a href="{{ route('prescriptions.edit', $prescription) }}?user_id={{ $prescription->user_id }}"
                                class="btn btn-info">@lang('Edit')</a>
                        @endcan
                        <button id="doPrint" class="btn btn-default"><i class="fas fa-print"></i> Print</button>
                    </div>
                </div>
                <div id="print-area" class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="invoice p-3 mb-3">
                                <div class="row">
                                    <h4 style="position: absolute; top: 45px; left: 39%;">Doctor Prescription</h4>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <h4 class="pb-3"><img src="{{ asset('assets/images/logo.png') }}"
                                                alt="{{ $ApplicationSetting->item_name }}" id="custom-opacity-sidebar"
                                                class="brand-image">{{ $ApplicationSetting->item_name }}</h4>
                                    </div>
                                </div>

                                <div class="row col-12 m-0 p-0">
                                    <div class="col-4">
                                        <h6 class="size">{{ $ApplicationSetting->company_address }}</h6>
                                    </div>
                                    <div class="col-8 text-right">
                                        <h6 class="size">@lang('Prescription ID'):
                                            {{ str_pad($prescription->id, 4, '0', STR_PAD_LEFT) }}</h6>
                                    </div>

                                </div>

                                <div class="row col-12 m-0 p-0">

                                    <div class="col-4">
                                        <h6 class="size">Email: {{ $ApplicationSetting->company_email }}</h6>
                                    </div>
                                    <div class="col-8 text-right">
                                        <h6 class="size">Patient: {{ $prescription->user->name ?? ' ' }}</h6>
                                    </div>

                                </div>
                                <div class="row col-12 m-0 p-0">

                                    <div class="col-4">
                                        <h6 class="size">Phone: {{ $ApplicationSetting->contact }}</h6>
                                    </div>
                                    <div class="col-8 text-right">
                                        <h6 class="size">Phone: {{ $prescription->user->phone ?? '-' }}</h6>
                                    </div>

                                </div>
                                <div class="row col-12 m-0 p-0">

                                    <div class="col-4">
                                        <h6 class="size">Doctor: {{ $prescription->doctor->name ?? '-' }}</h6>
                                    </div>
                                    <div class="col-8 text-right">
                                        <h6 class="size">Date:
                                            {{ date($companySettings->date_format ?? 'Y-m-d', strtotime($prescription->prescription_date)) }}
                                        </h6>
                                    </div>

                                </div>
                                <div class="row col-12 m-0 p-0">

                                    <div class="col-4">
                                        <h6 class="size"></h6>
                                    </div>
                                    <div class="col-8 text-right">
                                        <h6 class="size">MRN no:
                                            {{ $prescription->user->patientDetails->mrn_number ?? ' ' }}</h6>
                                    </div>

                                </div>
                                <hr class="pb-3">

                                <div class="row print-area" style="margin-bottom:60px !important;">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            {{-- id="t1" class="table custom-table" --}}
                                            <table class="table custom-table" style="border: 1px solid #17a2b8;">
                                                <thead>
                                                    <tr style="border: 1px solid #17a2b8 !important;">
                                                        <th style="border: 1px solid #17a2b8 !important; color:black !important;"
                                                            class="col-4 col-sm-4 col-md-4 col-lg-4" scope="col">
                                                            @lang('Medicine Name')</th>
                                                        <th style="border: 1px solid #17a2b8 !important; color:black !important;"
                                                            class="col-6 col-sm-6 col-md-6 col-lg-6" scope="col">
                                                            @lang('Description')</th>
                                                        {{-- <th style="border: 1px solid #17a2b8 !important; color:black !important;"
                                                            class="col-6 col-sm-6 col-md-6 col-lg-6" scope="col">
                                                            @lang('Instruction')</th> --}}
                                                        <th style="border: 1px solid #17a2b8 !important; color:black !important;"
                                                            class="col-2 col-sm-2 col-md-2 col-lg-2" scope="col">
                                                            @lang('Days')</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($prescription->patientmedicineitem as $item)
                                                        <tr>
                                                            <td style="border: 1px solid #17a2b8;">
                                                                {{ $item->ddmedicine->name ?? '-' }}</td>
                                                            <td style="border: 1px solid #17a2b8;">
                                                                {{ $item->ddmedicine->description ?? '-' }}</td>
                                                            {{-- <td style="border: 1px solid #17a2b8;">{{ $item->instruction }}
                                                            </td> --}}
                                                            <td style="border: 1px solid #17a2b8;">{{ $item->day }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" style="margin-bottom:60px !important;">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table  custom-table">
                                                <thead>
                                                    <tr>
                                                        <th style="border: 1px solid #17a2b8; color:black !important;"
                                                            class="col-4 col-sm-4 col-md-4 col-lg-4" scope="col">
                                                            @lang('Diagnosis')</th>
                                                        <th style="border: 1px solid #17a2b8; color:black !important;"
                                                            class="col-8 col-sm-8 col-md-8 col-lg-8" scope="col">
                                                            @lang('Instruction')</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($prescription->patientdiagnosisitem as $item)
                                                        <tr>
                                                            <td style="border: 1px solid #17a2b8; ">
                                                                {{ $item->dddiagnosis->name ?? '-' }}</td>
                                                            <td style="border: 1px solid #17a2b8; ">
                                                                {{ $item->instruction }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table  custom-table">
                                                <thead>
                                                    <tr>
                                                        <th style="border: 1px solid #17a2b8; color:black !important;"
                                                            class="col-6 col-sm-6 col-md-6 col-lg-6" scope="col">
                                                            @lang('Note')</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td style="border: 1px solid #17a2b8; ">{{ $prescription->note }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <p class="pl-4">
                This document is created by {{ $examInvestigation->creator->name ?? '-' }} at
                                        {{ $examInvestigation->created_at ?? '-' }} and printed by
                                        {{ Auth::user()->name }} at {{ now()->format('Y-m-d H:i:s') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
