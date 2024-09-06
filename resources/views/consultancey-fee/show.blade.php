@extends('layouts.layout')

@section('content')
<style>
    .table td,
    .table th {
        padding: 0.4rem !important;
    }

    @media (min-width: 1200px) {
        .col-xl-2 {
            max-width: 10.666667% !important;
        }
    }

    @media (min-width: 1200px) {
        .col-xl-3 {
            max-width: 38% !important;
        }
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

    .card-body {

        padding: 0.7rem;
    }
</style>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="form-group row">
                    <label class="col-md-12 col-form-label"></label>
                    <div class="col-md-12 d-flex align-items-center">
                        <a href="{{ route('patient-details.index') }}" class="btn btn-outline btn-warning btn-lg">
                            @lang('Patient List')
                        </a>
                        <a href="{{ route('consultancey-fees.index') }}" class="btn btn-outline btn-info btn-lg ml-2">
                            {{ __('Fee List') }}
                        </a>
                    </div>
                </div>
                <div class="col">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('consultancey-fees.index') }}">@lang('Consultancy Fee')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('Consultancy Fee Info')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Consultancy Fee Info')</h3>
                    <div class="card-tools">
                        <a href="{{ route('consultancey-fees.edit', $consultanceyFee->id) }}"
                            class="btn btn-info">@lang('Edit')</a>
                        <button id="doPrint" class="btn btn-default"><i class="fas fa-print"></i> Print</button>
                    </div>
                </div>

                <div id="print-area" class="card-body">
                    <div class="row" style="position:relative;">
                        <h4 style="position: absolute; top:30px; left: 39%;">Consultancy Fee</h4>
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
                            <h6 class="size">Patient: {{ $patientDetail->name }}</h6>
                        </div>

                    </div>

                    <div class="row col-12 p-0 m-0">

                        <div class="col-4">
                            <h6 class="size">Email: {{ $ApplicationSetting->company_email }}</h6>
                        </div>
                        <div class="col-8 text-right">
                            <h6 class="size">@lang('MRN no'):
                            {{ str_pad($patientDetail->patientDetails->mrn_number, 4, '0', STR_PAD_LEFT) }}
                            </h6>
                        </div>

                    </div>
                    <div class="row col-12 p-0 m-0">

                        <div class="col-4">
                            <h6 class="size">Phone: {{ $ApplicationSetting->contact }}</h6>
                        </div>
                        <div class="col-8 text-right">
                        @php
                            $age = calculateAge($patientDetail->date_of_birth);
                        @endphp

                            <h6 class="size">
                                @lang('Age'):
                                {{ $age['years'] }} Years <br></h6>
                        </div>

                    </div>
                    <div class="row col-12 p-0 m-0">

                    <div class="col-4">
                        <h6 class="size"></h6>
                    </div>
                    <div class="col-8 text-right">
                        <h6 class="size">
                        @lang('Date'):
                        {{ $consultanceyFee->date ? \Carbon\Carbon::parse($consultanceyFee->date)->format('d-M-Y') : '-' }} <br></h6>
                    </div>

                    </div>

                    <hr class="pb-3">

                    <div class="row col-12 m-0 p-0">
                        <div class="col-12 table-responsive">
                            <table class="table border border-dark">
                                <thead class="border-dark">
                                    <tr class="border-dark">
                                        <th scope="col" class="col-8 border-dark">@lang('Description')</th>
                                        <th scope="col" class="col-4 border-dark text-right">@lang('Amount')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $consultanceyFee->description }}</td>
                                        <td class="text-right">{{ $consultanceyFee->amount }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
    
                    <div class="row">
                        <div class="col-md-6 offset-md-6">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th class="text-right">@lang('Total')</th>
                                            <td class="text-right">{{ $consultanceyFee->amount }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
