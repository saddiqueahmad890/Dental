@extends('layouts.layout')

@section('content')
<style>
    .image-container {
        width: 100px; /* Adjust width as needed */
        height: 100px; /* Adjust height as needed */
        overflow: hidden; /* This ensures images don't overflow the container */
    }
    .image-container img {
        width: 100%; /* Stretch image to fill container width */
        height: 100%; /* Stretch image to fill container height */
        object-fit: cover; /* Crop image proportionally to fit container */
    }
    h6{
        font-size: 0.8rem !important;
    }
    .card-body {
        padding: 0.4rem !important;
    }
    @media print {
        .custom-tooth-issues{
            background-color: #fff !important;
        }
        div.custom-tooth-row {
            page-break-inside: avoid !important;
            page-break-before: auto; /* or use 'always' if needed */
            page-break-after: auto;  /* or use 'always' if needed */
        }
    }
</style>
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="form-group row">
                <label class="col-md-12 col-form-label"></label>
                <div class="col-md-12 d-flex align-items-center">
                    <a href="{{ route('patient-details.index') }}" class="btn btn-outline btn-warning mr-1">
                        @lang('Patient List')
                    </a>
                    <a href="{{ route('exam-investigations.index') }}" class="btn btn-outline btn-info">
                        {{ __('All Exam Investigation') }}
                    </a>
                </div>
            </div>

            <div class="col">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('exam-investigations.index') }}">@lang('Patient Exam Investigation')</a>
                    </li>
                    <li class="breadcrumb-item active">@lang('Patient Exam Investigation Info')</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info">
                <h3 class="card-title">@lang('Patient Exam Investigation Info')</h3>
                <div class="card-tools">
                    <a href="{{ route('exam-investigations.edit', $examInvestigation->id) }}"
                        class="btn btn-info">@lang('Edit')</a>
                    <button id="doPrint" class="btn btn-default"><i class="fas fa-print"></i> Print</button>
                </div>
            </div>

            <div id="print-area" class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="consultancy pr-3 pl-3">
                            <div class="row">
                                <h4 style="position: absolute; top:27px; left: 35%;">Examination & Investigation</h4>
                            </div>
                            <div class="row ">
                                <div class="col-12">
                                    <h4 class="pb-3"><img src="{{ asset('assets/images/logo.png') }}" alt="{{ $ApplicationSetting->item_name }}"
                                        id="custom-opacity-sidebar" class="brand-image">{{ $ApplicationSetting->item_name }}</h4>
                                </div>
                            </div>

                            <div class="row col-12 p-0 m-0">
                                <div class="col-4">
                                    <h6 class="size">{{ $ApplicationSetting->company_address }}</h6>
                                </div>
                                <div class="col-8 text-right">
                                    <h6 class="size">Patient: {{ $examInvestigation->patient->name }}</h6>
                                </div>
                            </div>

                            <div class="row col-12 p-0 m-0">
                                <div class="col-4">
                                    <h6 class="size">Email: {{ $ApplicationSetting->company_email }}</h6>
                                </div>
                                <div class="col-8 text-right">
                                    <h6 class="size">@lang('MRN no'):
                                    {{ str_pad($examInvestigation->patient->patientDetails->mrn_number, 4, '0', STR_PAD_LEFT) }}</h6>
                                </div>
                            </div>
                            <div class="row col-12 p-0 m-0">
                                <div class="col-4">
                                    <h6 class="size">Phone: {{ $ApplicationSetting->contact }}</h6>
                                </div>
                                <div class="col-8 text-right">
                                    <h6 class="size">@lang('Appointment no'):  {{ $examInvestigation->PatientAppointment->appointment_number ?? '-'}}</h6>
                                </div>
                            </div>
                            <div class="row col-12 p-0 m-0">
                                <div class="col-4">
                                    <h6 class="size">Doctor: {{ $examInvestigation->doctor->name }}</h6>
                                </div>
                                <div class="col-8 text-right">
                                @php
                                    $age = calculateAge($examInvestigation->patient->date_of_birth);
                                @endphp
                                    <h6 class="size">
                                   @lang('Age'):
                                    {{ $age['years'] }} Years <br></h6>
                                </div>
                            </div>
                            <div class="row col-12 p-0 m-0">
                                <div class="col-4">
                                    <h6 class="size">@lang('Examination no'):
                                    {{ $examInvestigation->examination_number }}</h6>
                                </div>
                                <div class="col-8 text-right">
                                    <h6 class="size">@lang('Exam Date'):
                                        {{ $examInvestigation->created_at ? \Carbon\Carbon::parse($examInvestigation->created_at)->format('d-M-Y') : '-' }}
                                    </h6>
                                </div>
                            </div>
                            <hr class="pb-3">

                            @foreach ($groupedTeeth as $issueGroup => $teethGroup)
                                <div class="row custom-tooth-row">
                                    <div class="col-12">
                                        <div class="card mb-3 " style="border:1px solid #17a2b8;">
                                            <div class="card-header bg-light d-flex align-items-center justify-content-between" style="border: 1px solid #17a2b8;">
                                                <div class="d-flex align-items-center">
                                                    @foreach ($teethGroup as $tooth)
                                                        {{-- <img src="{{ asset('assets/images/teeth/' . $tooth->tooth_number . '.png') }}" onerror="this.style.display='none'" style="max-height: 30px; max-width: 30px; object-fit: contain; margin-right: 10px;"> --}}
                                                    @endforeach
                                                    <h3 class="card-title mb-0" style="font-weight:bold;">
                                                        @lang('Tooth')
                                                        {{ $teethGroup->pluck('tooth_number')->join(', ') }}
                                                    </h3>
                                                </div>
                                                <div style="position: absolute; right: 20px;">
                                                    <input type="checkbox" id="attach-images-{{ $teethGroup->pluck('tooth_number')->join('-') }}" class="attach-images-checkbox">
                                                    <label for="attach-images-{{ $teethGroup->pluck('tooth_number')->join('-') }}" class="mb-0">@lang('Remove Images')</label>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <!-- Tooth Issues -->
                                                <div class="tooth-issues mt-0">
                                                    @foreach ($teethGroup->first()->toothIssues as $issue)
                                                        <div class="custom-tooth-issues alert alert-light mb-1" style="display: inline-block; margin-right: 30px;">
                                                            <h6 style="font-weight:bold; font-size:11px !important;">{{ $issue->tooth_issue }}</h6>
                                                            <p>{{ $issue->description }}</p>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="tooth-files mt-2">
                                                    @foreach ($files as $file)
                                                        @if ($teethGroup->pluck('tooth_number')->contains($file['child_record_id']))
                                                            <div class="image-container" style="display: inline-block; margin-right: 10px; margin-top:20px;">
                                                                <img style="height:100px; width:100px;" src="{{ asset('storage/uploads/patient/'.$examInvestigation->patient->id.'/exam_investigations/'.$examInvestigation->id.'/'.$file['child_record_id'].'/'.$file['file_name']) }}" alt="File" class="tooth-image">
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="row">
                                <p class="pl-2">
                                    This document is created by {{ $examInvestigation->creator->name ?? "-" }} at {{ $examInvestigation->created_at ?? "-" }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const attachImagesCheckboxes = document.querySelectorAll('.attach-images-checkbox');

            attachImagesCheckboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    const toothFilesDiv = this.closest('.card').querySelector('.tooth-files');

                    if (this.checked) {
                        toothFilesDiv.style.display = 'none'; // Hide the tooth-files div
                    } else {
                        toothFilesDiv.style.display = 'block'; // Show the tooth-files div
                    }
                });
            });
        });
    </script>
@endsection
