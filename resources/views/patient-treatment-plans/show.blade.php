@extends('layouts.layout')
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
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="form-group row">
                    <label class="col-md-12 col-form-label"></label>
                    <div class="col-md-12 d-flex align-items-center">
                        <a href="{{ route('patient-details.index') }}" class="btn btn-outline btn-warning mr-2">
                            @lang('Patient List')
                        </a>
                        <a href="{{ route('patient-treatment-plans.index') }}" class="btn btn-outline btn-info">
                            {{ __('All Treatment Plans') }}
                        </a>
                    </div>
                </div>



                <div class="col">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('patient-treatment-plans.index') }}">@lang('Patient Treatment Plans')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('Patient Treatment Plan Info')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Patient Treatment Plan Info')</h3>
                    <div class="card-tools">
                        <a href="{{ route('patient-treatment-plans.edit', $patientTreatmentPlan->id) }}"
                            class="btn btn-info">@lang('Edit')</a>
                        <button id="doPrint" class="btn btn-default"><i class="fas fa-print"></i> Print</button>
                    </div>
                </div>
                <div id="print-area" class="card-body border">
                    <div class="row" style="position:relative;">
                        <h4 style="position: absolute; top:30px; left: 39%;">Treatment Plans</h4>
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
                            <h6 class="size">Patient: {{ $patientTreatmentPlan->patient->name ?? '-' }}</h6>
                        </div>

                    </div>

                    <div class="row col-12 p-0 m-0">

                        <div class="col-4">
                            <h6 class="size">Email: {{ $ApplicationSetting->company_email }}</h6>
                        </div>
                        <div class="col-8 text-right">
                            <h6 class="size">@lang('MRN no'):
                                {{ str_pad(isset($patientTreatmentPlan->patient->patientDetails->mrn_number), 4, '0', STR_PAD_LEFT) }}
                            </h6>
                        </div>

                    </div>
                    <div class="row col-12 p-0 m-0">

                        <div class="col-4">
                            <h6 class="size">Phone: {{ $ApplicationSetting->contact }}</h6>
                        </div>
                        <div class="col-8 text-right">
                            <h6 class="size">@lang('Treatment Plan no'):
                                {{ $patientTreatmentPlan->treatment_plan_number }}</h6>
                        </div>

                    </div>
                    <div class="row col-12 p-0 m-0">

                        <div class="col-4">
                            <h6 class="size">Doctor: {{ $patientTreatmentPlan->doctor->name }}</h6>
                        </div>
                        <div class="col-8 text-right">
                            @php
                                $age = calculateAge($patientTreatmentPlan->patient->date_of_birth ?? ' '); // Provide a default date if dob is not set
                            @endphp

                            <h6 class="size">
                                @lang('Age'):
                                {{ $age['years'] }} Years <br></h6>
                        </div>

                    </div>
                    <div class="row col-12 p-0 m-0">

                        <div class="col-4">
                            <h6 class="size">@lang('Procedure no'):
                                {{ $patientTreatmentPlan->examinvestigation->examination_number ?? '' }}</h6>
                        </div>
                        <div class="col-8 text-right">
                            <h6 class="size">@lang('Treatment Plan Date'):
                                {{ $patientTreatmentPlan->created_at ? \Carbon\Carbon::parse($patientTreatmentPlan->created_at)->format('d-M-Y') : '-' }}

                            </h6>
                        </div>

                    </div>
                    <hr class="pb-3">
                    {{-- @foreach ($teeth as $tooth)
                        <div class="row tooth-row-{{ $tooth->tooth_number }}">
                            <div class="col-12">
                                <div class="card mb-3" style="border: 1px solid #17a2b8; ">
                                    <div class="card-header bg-light" style="border: 1px solid #17a2b8;">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('assets/images/teeth/' . $tooth->tooth_number . '.png') }}"
                                                onerror="this.style.display='none'"
                                                style="max-height: 30px; max-width: 30px; object-fit: contain; margin-right: 10px;">
                                            <h3 class="card-title" style="font-weight:bold;">@lang('Tooth')
                                                {{ $tooth->tooth_number }}</h3>
                                        </div>
                                    </div>
                                    <div class="card-body pt-3 pb-2">
                                        <!-- Tooth Issues -->
                                        <div class="tooth-issues mb-0 row" style="margin-left:1px;">
                                            @foreach ($tooth->toothIssues as $issue)
                                                <div class="alert alert-light mb-0 p-0"
                                                    style="display: flex;align-items: center;width: max-content; margin-right: 10px !important; border:none;">
                                                    <h6 style="font-size:11px !important; font-weight:bold;">
                                                        {{ $issue->tooth_issue }}:&nbsp</h6>
                                                    <p style="font-size:11px;">{{ $issue->description }}</p>
                                                </div>
                                            @endforeach
                                        </div>

                                        <!-- Treatment Procedures -->
                                        <div class="table-responsive">
                                            <table class="table table-hover border tooth-treatment custom-table">
                                                <thead>
                                                    <tr>
                                                        <th style="border:1px solid #17a2b8 !important;" class="border">
                                                            @lang('Procedure Category')</th>
                                                        <th style="border:1px solid #17a2b8 !important;" class="border">
                                                            @lang('Procedure')</th>
                                                        <th style="border:1px solid #17a2b8 !important;" class="border">
                                                            @lang('Cost')</th>
                                                        <th style="border:1px solid #17a2b8 !important;" class="border">
                                                            @lang('Status')</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($patientTreatmentPlanProcedures->where('tooth_number', $tooth->tooth_number)->isNotEmpty())
                                                        @foreach ($patientTreatmentPlanProcedures->where('tooth_number', $tooth->tooth_number) as $planProcedure)
                                                            <tr class="treatment-plan-inner-row">
                                                                <td
                                                                    style="border:1px solid #17a2b8 !important;"class="border col-xl-4  col-sm-4 col-md-4">
                                                                    <span>{{ $planProcedure->procedure->ddprocedurecategory->title ?? '-' }}</span>
                                                                </td>
                                                                <td
                                                                    style="border:1px solid #17a2b8 !important;"class="border col-xl-4 col-sm-4  col-lg-4 col-md-4">
                                                                    <span>{{ $planProcedure->procedure->title ?? '-' }}</span>
                                                                </td>
                                                                <td
                                                                    style="border:1px solid #17a2b8 !important;"class="border col-xl-2 col-sm-2  col-lg-2 col-md-2">
                                                                    <span
                                                                        class="cost">{{ $planProcedure->procedure->price ?? '-' }}</span>
                                                                </td>
                                                                <td
                                                                    style="border:1px solid #17a2b8 !important;"class="border col-xl-2 col-sm-2  col-lg-2 col-md-2">
                                                                    <span class="text-center">
                                                                        @if ($planProcedure->ready_to_start === 'yes' && $planProcedure->is_procedure_started === 'no')
                                                                            Ready to Procedure
                                                                        @elseif ($planProcedure->is_procedure_started === 'yes' && $planProcedure->is_procedure_finished === 'no')
                                                                            Procedure Started
                                                                        @elseif ($planProcedure->is_procedure_finished === 'yes')
                                                                            Procedure Finished
                                                                        @else
                                                                            Yet to be Added
                                                                        @endif
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr class="treatment-plan-inner-row">
                                                            <td colspan="4" class="text-center">@lang('No treatment procedures found for this tooth.')</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach --}}

                    @foreach ($groupedTeeth as $issue => $teethGroup)
                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-3" style="border: 1px solid #17a2b8; ">
                                <div class="card-header bg-light" style="border: 1px solid #17a2b8;">
                                    <h3 class="card-title" style="font-weight:bold;">
                                         Tooth: 
                                        @foreach($teethGroup as $tooth)
                                            {{ $tooth->tooth_number }},
                                        @endforeach
                                        
                                    </h3>
                                </div>
                                <div class="card-body pt-3 pb-2">
                                    <div class="table-responsive">
                                        <table class="table table-hover border tooth-treatment custom-table">
                                            <thead>
                                                <tr>
                                                    <th style="border:1px solid #17a2b8 !important;" class="border">@lang('Procedure Category')</th>
                                                    <th style="border:1px solid #17a2b8 !important;" class="border">@lang('Procedure')</th>
                                                    <th style="border:1px solid #17a2b8 !important;" class="border">@lang('Cost')</th>
                                                    <th style="border:1px solid #17a2b8 !important;" class="border">@lang('Status')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <div class="custom-tooth-issues alert alert-light mb-1" style="display: inline-block; margin-right: 30px;">
                                                    <h6 style="font-weight:bold; font-size:11px !important;">{{ $issue }}</h6>
                                                    {{-- <p>{{ $issue->description }}</p> --}}
                                                </div>
                                                
                                                    @foreach ($patientTreatmentPlanProcedures->where('tooth_number', $tooth->tooth_number) as $planProcedure)
                                                        <tr class="treatment-plan-inner-row">
                                                            <td style="border:1px solid #17a2b8 !important;" class="border col-xl-4 col-sm-4 col-md-4">
                                                                <span>{{ $planProcedure->procedure->ddprocedurecategory->title ?? '-' }}</span>
                                                            </td>
                                                            <td style="border:1px solid #17a2b8 !important;" class="border col-xl-4 col-sm-4 col-lg-4 col-md-4">
                                                                <span>{{ $planProcedure->procedure->title ?? '-' }}</span>
                                                            </td>
                                                            <td style="border:1px solid #17a2b8 !important;" class="border col-xl-2 col-sm-2 col-lg-2 col-md-2">
                                                                <span class="cost">{{ $planProcedure->procedure->price ?? '-' }}</span>
                                                            </td>
                                                            <td style="border:1px solid #17a2b8 !important;" class="border col-xl-2 col-sm-2 col-lg-2 col-md-2">
                                                                <span class="text-center">
                                                                    @if ($planProcedure->ready_to_start === 'yes' && $planProcedure->is_procedure_started === 'no')
                                                                        Ready to Procedure
                                                                    @elseif ($planProcedure->is_procedure_started === 'yes' && $planProcedure->is_procedure_finished === 'no')
                                                                        Procedure Started
                                                                    @elseif ($planProcedure->is_procedure_finished === 'yes')
                                                                        Procedure Finished
                                                                    @else
                                                                        Yet to be Added
                                                                    @endif
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                

                    @if ($allTeethProcedures->isNotEmpty())
                        <div class="row tooth-row-all-teeth">
                            <div class="col-12">
                                <div class="card mb-3" style="border: 1px solid #17a2b8;">
                                    <div class="card-header bg-light" style="border: 1px solid #17a2b8;">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('assets/images/teeth/18.png') }}"
                                                onerror="this.style.display='none'"
                                                style="max-height: 30px; max-width: 30px; object-fit: contain; margin-right: 10px;">
                                            <h3 class="card-title" style="font-weight:bold;">@lang('Treatment Plan For All Teeth')</h3>
                                        </div>
                                    </div>
                                    <div class="card-body pt-3 pb-2">
                                        <!-- Treatment Procedures -->
                                        <div class="table-responsive">
                                            <table class="table table-hover border tooth-treatment custom-table">
                                                <thead>
                                                    <tr>
                                                        <th style="border:1px solid #17a2b8 !important;" class="border">
                                                            @lang('Procedure Category')</th>
                                                        <th style="border:1px solid #17a2b8 !important;" class="border">
                                                            @lang('Procedure')</th>
                                                        <th style="border:1px solid #17a2b8 !important;" class="border">
                                                            @lang('Cost')</th>
                                                        <th style="border:1px solid #17a2b8 !important;" class="border">
                                                            @lang('Status')</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($allTeethProcedures as $planProcedure)
                                                        <tr class="treatment-plan-inner-row">
                                                            <td style="border:1px solid #17a2b8 !important;" class="border col-xl-4  col-sm-4 col-md-4">
                                                                <span>{{ $planProcedure->procedure->ddprocedurecategory->title ?? '-' }}</span>
                                                            </td>
                                                            <td style="border:1px solid #17a2b8 !important;" class="border col-xl-4 col-sm-4  col-lg-4 col-md-4">
                                                                <span>{{ $planProcedure->procedure->title ?? '-' }}</span>
                                                            </td>
                                                            <td style="border:1px solid #17a2b8 !important;" class="border col-xl-2 col-sm-2  col-lg-2 col-md-2">
                                                                <span class="cost">{{ $planProcedure->procedure->price ?? '-' }}</span>
                                                            </td>
                                                            <td style="border:1px solid #17a2b8 !important;" class="border col-xl-2 col-sm-2  col-lg-2 col-md-2">
                                                                <span class="text-center">
                                                                    @if ($planProcedure->ready_to_start === 'yes' && $planProcedure->is_procedure_started === 'no')
                                                                        Ready to Procedure
                                                                    @elseif ($planProcedure->is_procedure_started === 'yes' && $planProcedure->is_procedure_finished === 'no')
                                                                        Procedure Started
                                                                    @elseif ($planProcedure->is_procedure_finished === 'yes')
                                                                        Procedure Finished
                                                                    @else
                                                                        Yet to be Added
                                                                    @endif
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if (!is_null($totalPrice))
                        <div class="row">
                            <div class="col-12 text-right font-weight-bold mt-3" style="padding-right: 30px;">
                                <p style="font-size:16px;">Total Price: {{ $totalPrice }}</p>
                            </div>
                        </div>
                    @endif


                    <div class="row">
                        <p class="pl-2">
                            This document is created by {{ $patientTreatmentPlan->creator->name ?? '-' }} at
                            {{ $patientTreatmentPlan->created_at ?? '-' }} and printed by {{ Auth::user()->name }} at
                            {{ now()->format('Y-m-d H:i:s') }}
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
