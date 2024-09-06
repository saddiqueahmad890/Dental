@extends('layouts.layout')
@section('one_page_css')
    <link href="{{ asset('assets/css/teethv2.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
@endsection
@section('content')
    <section class="content-header">
        <style>
            /* Custom styles for dropdown menu */
            .dropdown-menu {
                padding: 0;
                /* Remove padding from the dropdown menu */
                border-radius: 0.25rem;
                /* Adjust border radius as needed */
            }

            .dropdown-item {
                padding: 0.5rem 1rem;
                /* Adjust padding for dropdown items */
                border-bottom: 1px solid #dee2e6;
                /* Add a border between items */
            }

            .dropdown-item:last-child {
                border-bottom: none;
                /* Remove border from the last item */
            }

            .dropdown-divider {
                margin: 0;
                /* Remove margin from the divider */
            }
        </style>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6 d-flex">
                    <h3 class="mr-2"><a href="{{ route('exam-investigations.create') }}" class="btn btn-outline btn-info">+
                            @lang('Add New Examination')</a>
                        <span class="pull-right"></span>
                    </h3>
                    <h3><a href="{{ route('exam-investigations.index') }}" class="btn btn-outline btn-info">
                            <i class="fas fa-eye"></i> @lang('View All')</a>
                        <span class="pull-right"></span>
                    </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('exam-investigations.index') }}">{{ __('Existing Teeth Examinations') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('Edit') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Patient Dental Analysis')</h3>
                </div>
                <div class="card-body">
                    <form id="patientForm" class="form-material form-horizontal bg-custom"
                        action="{{ isset($examInvestigation) ? route('exam-investigations.update', $examInvestigation) : route('exam-investigations.store') }}"
                        method="POST" enctype="multipart/form-data" data-parsley-validate>
                        @csrf
                        @if (isset($examInvestigation))
                            @method('PUT')
                        @endif
                        <div class="row col-12 m-0 p-0">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                                <div class="form-group">
                                    <label for="patient_id">@lang('Patient')</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-heartbeat"></i></span>
                                        </div>
                                        <select name="patient_id"
                                            class="form-control select2 @error('patient_id') is-invalid @enderror" required
                                            id="patient_id" {{ isset($examInvestigation) ? 'disabled' : '' }}
                                            data-parsley-required="true"
                                            data-parsley-required-message="Please select patient."">
                                            <option value="" disabled
                                                {{ old('patient_id', isset($examInvestigation) ? $examInvestigation->patient_id : null) == null ? 'selected' : '' }}>
                                                {{ isset($examInvestigation) ? '' : 'Select Patient' }}
                                            </option>
                                            @foreach ($patients as $patient)
                                                <option value="{{ $patient->id }}"
                                                    @if (old('patient_id', isset($examInvestigation) ? $examInvestigation->patient_id : '') == $patient->id) selected @endif>
                                                    {{ $patient->name }} -
                                                    {{ $patient->patientDetails->mrn_number ?? ' ' }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if (isset($examInvestigation))
                                            <input type="hidden" name="patient_id"
                                                value="{{ $examInvestigation->patient_id }}">
                                        @endif
                                        @error('patient_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                                <div class="form-group">
                                    <label for="patient_appointment_id">@lang('Select Appointment')</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-heartbeat"></i></span>
                                        </div>
                                        @if (isset($examInvestigation))
                                            <input type="text" class="form-control"
                                                value="{{ $examInvestigation->PatientAppointment->appointment_number }}"
                                                readonly>
                                            <input type="hidden" name="patient_appointment_id"
                                                value="{{ $examInvestigation->patient_appointment_id }}">
                                        @else
                                            <select name="patient_appointment_id"
                                                class="form-control select2 @error('patient_appointment_id') is-invalid @enderror"
                                                required id="patient_appointment_id" data-parsley-required="true"
                                                data-parsley-required-message="Please select appointment">
                                                <option value="" disabled selected>Select Appointment</option>
                                                <!-- AJAX will populate this -->
                                            </select>
                                        @endif
                                        @error('patient_appointment_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                                <div class="form-group">
                                    <label for="doctor_id">@lang('Doctor') <b class="ambitious-crimson">*</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-heartbeat"></i></span>
                                        </div>
                                        @if (isset($examInvestigation))
                                            <input type="text" class="form-control"
                                                value="{{ $examInvestigation->doctor->name }}" readonly>
                                            <input type="hidden" name="doctor_id"
                                                value="{{ $examInvestigation->doctor_id }}">
                                        @else
                                            <select name="doctor_id"
                                                class="form-control select2 @error('doctor_id') is-invalid @enderror"
                                                required id="doctor_id" data-parsley-required="true"
                                                data-parsley-required-message="Please select doctor.">
                                                <option value="" disabled selected>Select Doctor</option>
                                                <!-- AJAX will populate this -->
                                            </select>
                                        @endif
                                        @error('doctor_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row col-12 m-0 p-0">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-8">
                                <div class="form-group">
                                    <label for="comments">@lang('Chief Complaints')</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                                        </div>
                                        <input type="text" id="comments" name="comments"
                                            value="{{ old('comments', isset($examInvestigation) ? $examInvestigation->comments : '') }}"
                                            class="form-control" placeholder="@lang('Comments')">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row col-12 m-0 p-0">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-3 col-form-label"></label>
                                    <div class="col-md-12">
                                        <input type="submit"
                                            value="{{ isset($examInvestigation) ? __('Update Examination') : __('Add Examination') }}"
                                            class="btn btn-outline btn-info mr-2 mt-2 mt-sm-0" />
                                        <a href="{{ route('exam-investigations.index') }}"
                                            class="btn btn-outline btn-warning mt-2 mt-sm-0">{{ __('Cancel') }}</a>
                                        @if (isset($examInvestigation))
                                            <div class="btn-group">
                                                <button type="button"
                                                    class="btn btn-outline btn-success dropdown-toggle mt-2 mt-sm-0"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    {{ __('Treatment Plans') }}
                                                </button>
                                                <div class="dropdown-menu">
                                                    @forelse ($existingPlans as $plan)
                                                        <a class="dropdown-item mt-2 mt-sm-0"
                                                            href="{{ route('patient-treatment-plans.show', $plan) }}">
                                                            {{ __($plan->treatment_plan_number) }}
                                                        </a>
                                                    @empty
                                                        <a class="dropdown-item mt-2 mt-sm-0" href="#">
                                                            {{ __('No Existing Plans') }}
                                                        </a>
                                                    @endforelse
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item mt-2 mt-sm-0"
                                                        href="{{ route('patient-treatment-plans.create', ['examination_id' => $examInvestigation->id]) }}">
                                                        {{ __('Create New Plan') }}
                                                    </a>
                                                </div>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Chief Complaint History')</h3>
                </div>
                <div class="card-body">
                    <form id="chiefComplaintForm" class="form-material form-horizontal bg-custom p-4" method="POST" data-parsley-validate>
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="historyChiefComplaint" class="form-label">Chief Complaint</label>
                                <select name="history_chief_complaint_id" id="historyChiefComplaint" class="form-control" disabled>
                                    <option value="" disabled selected>Select Option</option>
                                    @foreach ($chiefcomplaints as $chiefcomplaint)
                                        <option value="{{ $chiefcomplaint->id }}">{{ $chiefcomplaint->complaint_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 align-self-end">
                                <div class="form-check mb-4">
                                    <input type="checkbox" name="check" id="check" class="form-check-input" checked>
                                </div>
                            </div>
                        </div>
                    
                        <input type="hidden" name="exam_investigation_id" id="examInvestigationId" value="{{ $examInvestigation->id }}">
                    
                        <div class="row">
                            <div class="col-12">
                                <input type="submit" value="Submit" class="btn btn-primary">
                            </div>
                        </div>
                    </form>                                                                                                                        
                </div>
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Extra Oral')</h3>
                </div>
                <div class="card-body">
                    <form id="extraOral" class="form-material form-horizontal bg-custom p-4" method="POST" data-parsley-validate>
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="historyChiefComplaint" class="form-label">Extra Oral</label>
                                <select name="extra_oral" id="extra_oral" class="form-control" disabled>
                                    <option value="" disabled selected>Select Option</option>
                                    @foreach ($extraOrals as $extraOral)
                                        <option value="{{ $extraOral->id }}">{{ $extraOral->extra_oral_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 align-self-end">
                                <div class="form-check mb-4">
                                    <input type="checkbox" name="check" id="checkuser" class="form-check-input" checked>
                                </div>
                            </div>
                        </div>
                    
                        <input type="hidden" name="exam_investigation_id" id="examInvestigationId" value="{{ $examInvestigation->id }}">
                    
                        <div class="row">
                            <div class="col-12">
                                <input type="submit" value="Submit" class="btn btn-primary">
                            </div>
                        </div>
                    </form>                                                                                                                        
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Intra Oral')</h3>
                </div>
                <div class="card-body">
                    <form id="intraOral" class="form-material form-horizontal bg-custom p-4" method="POST" data-parsley-validate>
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="historyChiefComplaint" class="form-label">Intra Oral</label>
                                <select name="intra_oral_id" id="intra_oral_id" class="form-control" disabled>
                                    <option value="" disabled selected>Select Option</option>
                                    @foreach ($intraOrals as $intraOral)
                                        <option value="{{ $intraOral->id }}">{{ $intraOral->intra_oral_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 align-self-end">
                                <div class="form-check mb-4">
                                    <input type="checkbox" name="intra_oral_check" id="intra_oral_check" class="form-check-input" checked>
                                </div>
                            </div>
                        </div>
                    
                        <input type="hidden" name="exam_investigation_id" id="examInvestigationId" value="{{ $examInvestigation->id }}">
                    
                        <div class="row">
                            <div class="col-12">
                                <input type="submit" value="Submit" class="btn btn-primary">
                            </div>
                        </div>
                    </form>                                                                                                                        
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Soft Tissues')</h3>
                </div>
                <div class="card-body">
                    <form id="softtissue" class="form-material form-horizontal bg-custom p-4" method="POST" data-parsley-validate>
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="historyChiefComplaint" class="form-label">Soft Tissues</label>
                                <select name="soft_tissue_id" id="soft_tissue_id" class="form-control" disabled>
                                    <option value="" disabled selected>Select Option</option>
                                    @foreach ($softTissues as $softTissue)
                                        <option value="{{ $softTissue->id }}">{{ $softTissue->soft_tissues_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 align-self-end">
                                <div class="form-check mb-4">
                                    <input type="checkbox" name="soft_tissues" id="check_soft_tissue" class="form-check-input" checked>
                                </div>
                            </div>
                        </div>
                    
                        <input type="hidden" name="exam_investigation_id" id="examInvestigationId" value="{{ $examInvestigation->id }}">
                    
                        <div class="row">
                            <div class="col-12">
                                <input type="submit" value="Submit" class="btn btn-primary">
                            </div>
                        </div>
                    </form>                                                                                                                        
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Hard Tissues')</h3>
                </div>
                <div class="card-body">
                    <form id="hardtissue" class="form-material form-horizontal bg-custom p-4" method="POST" data-parsley-validate>
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="historyChiefComplaint" class="form-label">Hard Tissues</label>
                                <select name="hard_tissue_id" id="hard_tissue_id" class="form-control" disabled>
                                    <option value="" disabled selected>Select Option</option>
                                    @foreach ($hardTissues as $hardTissue)
                                        <option value="{{ $hardTissue->id }}">{{ $hardTissue->hard_tissue_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 align-self-end">
                                <div class="form-check mb-4">
                                    <input type="checkbox" name="check_hard_tissue_id" id="check_hard_tissue_id" class="form-check-input" checked>
                                </div>
                            </div>
                        </div>
                    
                        <input type="hidden" name="exam_investigation_id" id="examInvestigationId" value="{{ $examInvestigation->id }}">
                    
                        <div class="row">
                            <div class="col-12">
                                <input type="submit" value="Submit" class="btn btn-primary">
                            </div>
                        </div>
                    </form>                                                                                                                        
                </div>
            </div>
        </div>
    </div>


    <div class="card">

        <div class="card-header bg-info">
            {{ optional($patient_record->user)->name }}'s history
        </div>
        
        <div class="card-body">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                        aria-controls="home" aria-selected="true">Medical History</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                        aria-controls="profile" aria-selected="false">Drug History</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="messages-tab" data-toggle="tab" href="#messages" role="tab"
                        aria-controls="messages" aria-selected="false">Social History</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="settings-tab" data-toggle="tab" href="#settings" role="tab"
                        aria-controls="settings" aria-selected="false">Dental History</a>
                </li>
            </ul>

            <!-- Tab content -->
            <div class="tab-content" id="myTabContent"
                style="    border-left: 1px solid #ccc;    border: 1px solid #ccc;    margin-top: -1px;    padding: 20px;">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="col-md-10">
                        <h3>@lang('Medical History of') {{ optional($patient_record->user)->name }}</h3>
                    </div>
                    <hr>
                    <p>
                    <div class="row">
                        {{-- @foreach ($dentalRecords as $dentalRecord) --}}
                            <div class="col-xl-3 p-3">
                                <div class="form-group m-0">
                                    <label>{{ $dentalRecord->ddMedicalHistory->title ?? ' ' }}</label>
                                    <p>{{ optional($dentalRecord->patientMedicalHistory)->comments }}</p>
                                </div>
                            </div>
                        {{-- @endforeach --}}
                    </div>
                    <div class="card">
                        <div class="card-header bg-info">
                            <h3 class="card-title"> Medical Documents</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="col-md-12">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>@lang('File Name')</th>
                                                    <th>@lang('Uploaded By')</th>
                                                    <th>@lang('Upload Date')</th>
                                                    <th>@lang('Action')</th>
                                                </tr>
                                            </thead>
                                            <tbody id="medicalHistoryTableBody" class="fileTableBody"></tbody>
                                            <!-- Other files will be loaded here via AJAX -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </p>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="col-md-10">
                        <h3>@lang('Drug History of') {{ optional($patient_record->user)->name }}</h3>
                    </div>
                    <hr>
                    <p>
                    <div class="row">
                        {{-- @foreach ($patientDrugHistories as $item) --}}
                            <div class="col-xl-3 p-3">
                                <div class="form-group m-0">
                                    <label for="Name">{{ optional($drug->dddrughistory)->title }}</label>
                                    <p>{{ optional($drug->patientDrugHistory)->comments }}</p>
                                </div>
                            </div>
                        {{-- @endforeach --}}
                    </div>
                    <div class="card">
                        <div class="card-header bg-info">
                            <h3 class="card-title"> Drug Documents</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="col-md-12">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>@lang('File Name')</th>
                                                    <th>@lang('Uploaded By')</th>
                                                    <th>@lang('Upload Date')</th>
                                                    <th>@lang('Action')</th>
                                                </tr>
                                            </thead>
                                            <tbody id="drugHistoryTableBody" class="fileTableBody"></tbody>
                                            <!-- Other files will be loaded here via AJAX -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </p>

                </div>
                <div class="tab-pane fade" id="messages" role="tabpanel" aria-labelledby="messages-tab">
                    <div class="col-md-10">
                        <h3>@lang('Social History of') {{ optional($patient_record->user)->name }}</h3>
                    </div>
                    <hr>
                    <p>
                    <div class="row">
                        {{-- @foreach ($patientSocialHistories as $item) --}}
                            <div class="col-xl-3 p-3">
                                <div class="form-group m-0">
                                    @if($social && $social->patientsocial)
                            <label>{{ optional($social->patientsocial->ddDrug)->title }}</label>
                            <p>{{ optional($social->patientsocial)->comments }}</p>
                        @else
                            <p>No data found</p>
                        @endif

                                </div>
                            </div>
                        {{-- @endforeach --}}
                    </div>
                    <div class="card">
                        <div class="card-header bg-info">
                            <h3 class="card-title"> Social Documents</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="col-md-12">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>@lang('File Name')</th>
                                                    <th>@lang('Uploaded By')</th>
                                                    <th>@lang('Upload Date')</th>
                                                    <th>@lang('Action')</th>
                                                </tr>
                                            </thead>
                                            <tbody id="socialHistoryTableBody" class="fileTableBody"></tbody>
                                            <!-- Other files will be loaded here via AJAX -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </p>
                </div>
                <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                    <div class="col-md-10">
                        <h3>@lang('Dental History of') {{ optional($patient_record->user)->name }}</h3>
                    </div>
                    <hr>
                    <p>
                    <div class="row">
                        {{-- @foreach ($patientDentalHistories as $item) --}}
                        <div class="col-xl-3 p-3">
                            <div class="form-group m-0">
                                {{-- @if($history_dental && $history_dental->dddental) --}}
                                    <label>{{ optional($history_dental->dddentalhistory)->title }}</label>
                                    <p>{{  optional($history_dental->patientdentalHistory)->comments }}</p>
                                {{-- @else --}}
                                    <label>Umer</label>
                                    <p>Umer</p>
                                {{-- @endif --}}
                                <label for="">{{ optional($social->patientsocial)->title }}</label>
                                <p>{{ optional($social->patientsocial)->comments }}</p>
                            </div>
                        </div>
                        
                        {{-- @endforeach --}}
                    </div>
                    <div class="card">
                        <div class="card-header bg-info">
                            <h3 class="card-title"> Dental Documents</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="col-md-12">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>@lang('File Name')</th>
                                                    <th>@lang('Uploaded By')</th>
                                                    <th>@lang('Upload Date')</th>
                                                    <th>@lang('Action')</th>
                                                </tr>
                                            </thead>
                                            <tbody id="dentalHistoryTableBody" class="fileTableBody"></tbody>
                                            <!-- Other files will be loaded here via AJAX -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </p>
                </div>
            </div>

        </div>

    </div>


    


        <div class="row">
        <div class="col-md-12">
            <div class="card" style="display: {{ isset($examInvestigation) ? 'block' : 'none' }};">
                <div class="card-header bg-info">
                    <h3 class="card-title">Dental Chart</h3>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6">

                            <div class="bg-custom p-2">
                                <div class="type-of-selection"
                                    style="display: {{ isset($examInvestigation) ? 'block' : 'none' }};">
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" value="single" id="option-single-selection" checked
                                                class="form-check-input" name="optradio">Single Selection
                                        </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" value="bulk" id="option-bulk-selection"
                                                class="form-check-input" name="optradio">Bulk Selection
                                        </label>
                                    </div>
                                </div>
                                <div
                                    class="exam-investigation-checkboxes col-xl-6 col-md-12 col-sm-12 d-flex justify-content-start align-content-center mt-3">
                                    <div class="check-mixed mr-3">
                                        <input style="margin-top:4px !important;"
                                            class="form-check-input check-input-mixed mx-0" type="checkbox"
                                            id="check-mixed" value="mixed"
                                            {{ isset($examInvestigation) && $examInvestigation->jaw_type === 'mixed' ? 'checked' : '' }}
                                            {{ ($counter ?? 0) > 0 ? 'disabled' : '' }}>
                                        <label class="form-check-label ml-3" for="check-mixed">
                                            Mixed
                                        </label>
                                    </div>
                                    <div class="check-adult mr-3">
                                        <input style="margin-top:4px !important;"
                                            class="form-check-input check-input-adult mx-0" type="checkbox"
                                            id="check-adult" value="adult"
                                            {{ isset($examInvestigation) && $examInvestigation->jaw_type === 'adult' ? 'checked' : '' }}
                                            {{ ($counter ?? 0) > 0 ? 'disabled' : '' }}>
                                        <label class="form-check-label ml-3" for="check-adult">
                                            Adult
                                        </label>
                                    </div>
                                    <div class="check-children">
                                        <input style="margin-top:4px !important;"
                                            class="form-check-input check-input-children mx-0" type="checkbox"
                                            id="check-children" value="children"
                                            {{ isset($examInvestigation) && $examInvestigation->jaw_type === 'children' ? 'checked' : '' }}
                                            {{ ($counter ?? 0) > 0 ? 'disabled' : '' }}>
                                        <label class="form-check-label ml-3" for="check-children">
                                            Children
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="area-bulk-selection bg-custom" style="display: none; margin-top: 30px;">
                                <form id="teethForm"
                                    style="display: {{ isset($examInvestigation) ? 'block' : 'none' }};">
                                    @csrf
                                    @if (isset($examInvestigation))
                                        <input type="hidden" name="doctor_id"
                                            value="{{ $examInvestigation->doctor_id }}">
                                        <input type="hidden" name="patient_id"
                                            value="{{ $examInvestigation->patient_id }}">
                                        <input type="hidden" name="examination_id"
                                            value="{{ $examInvestigation->id }}">
                                    @endif
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table id="teeth_issues" class="table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col" class="col-2">@lang('Tooth Issue')</th>
                                                            <th scope="col" class="col-5">@lang('Description')</th>
                                                            <th scope="col" class="custom-white-space">
                                                                @lang('Add / Remove')</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <select name="tooth_issue[]"
                                                                    class="form-control tooth_issue" required>
                                                                    <option value="">--@lang('Select')--</option>
                                                                    <option value="Carious Class1">Carious Class1</option>
                                                                    <option value="Carious Class2">Carious Class2</option>
                                                                    <option value="Carious Class3">Carious Class3</option>
                                                                    <option value="Mobility Grade1">Mobility Grade1
                                                                    </option>
                                                                    <option value="Mobility Grade2">Mobility Grade2
                                                                    </option>
                                                                    <option value="Mobility Grade3">Mobility Grade3
                                                                    </option>
                                                                    <option value="BDR">BDR</option>
                                                                    <option value="Filled">Filled</option>
                                                                    <option value="Missing">Missing</option>
                                                                    <option value="FPD">FPD</option>
                                                                    <option value="RPD">RPD</option>
                                                                    <option value="Plaque & Calulus deposits">Plaque &
                                                                        Calulus deposits</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <textarea name="description[]" class="form-control" rows="1" placeholder="@lang('Description')"></textarea>
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-info m-add"><i
                                                                        class="fas fa-plus"></i></button>
                                                                <button type="button" class="btn btn-info m-remove"
                                                                    disabled><i class="fas fa-trash"></i></button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary mb-2 ml-3"
                                        id="submitButton">Submit</button>
                                </form>
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="Base area-single-selection" style="display: block;">

                                <div class="teeth-container">
                                    <div id="adult-teeth"
                                        style="{{ isset($examInvestigation) && $examInvestigation->jaw_type === 'children' ? 'display: none;' : '' }}">
                                        <div class="teeth teeth-11">
                                            <span
                                                style="position:absolute;
                                left:13px;
                                top:-22px;">
                                                11
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/11.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-12">
                                            <span
                                                style="position:absolute;
                                left:0px;
                                top:-23px;">
                                                12
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/12.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-13">
                                            <span
                                                style="position:absolute;
                                left:-12px;
                                top:-16px;">
                                                13
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/13.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-14">
                                            <span
                                                style="position:absolute;
                                left:-20px;
                                top:-7px;">
                                                14
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/14.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-15">
                                            <span
                                                style="position:absolute;
                                left:-23px;
                                top:-7px;">
                                                15
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/15.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-16">
                                            <span
                                                style="position:absolute;
                                left:-25px;
                                top:7px;">
                                                16
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/16.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-17">
                                            <span
                                                style="position:absolute;
                                left:-25px;
                                top:6px;">
                                                17
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/17.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-18">
                                            <span
                                                style="position:absolute;
                                left:-27px;
                                top:6px;">
                                                18
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/18.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-21">
                                            <span
                                                style="position:absolute;
                                left:20px;
                                top:-22px;">
                                                21
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/21.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-22">
                                            <span
                                                style="position:absolute;
                                left:30px;
                                top:-23px;">
                                                22
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/22.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-23">
                                            <span
                                                style="position:absolute;
                                left:42px;
                                top:-16px;">
                                                23
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/23.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-24">
                                            <span
                                                style="position:absolute;
                                left:54px;
                                top:-7px;">
                                                24
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/24.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-25">
                                            <span
                                                style="position:absolute;
                                left:54px;
                                top:-7px;">
                                                25
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/25.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-26">
                                            <span
                                                style="position:absolute;
                                left:60px;
                                top:7px;">
                                                26
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/26.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-27">
                                            <span
                                                style="position:absolute;
                                left:57px;
                                top:6px;">
                                                27
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/27.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-28">
                                            <span
                                                style="position:absolute;
                                left:60px;
                                top:6px;">
                                                28
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/28.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-31">
                                            <span
                                                style="position:absolute;
                                left:20px;
                                top:35px;">
                                                31
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/31.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-32">
                                            <span
                                                style="position:absolute;
                                left:30px;
                                top:36px;">
                                                32
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/32.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-33">
                                            <span
                                                style="position:absolute;
                                left:42px;
                                top:30px;">
                                                33
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/33.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-34">
                                            <span
                                                style="position:absolute;
                                left:44px;
                                top:30px;">
                                                34
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/34.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-35">
                                            <span
                                                style="position:absolute;
                                left:44px;
                                top:20px;">
                                                35
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/35.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-36">
                                            <span
                                                style="position:absolute;
                                left:60px;
                                top:15px;">
                                                36
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/36.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-37">
                                            <span
                                                style="position:absolute;
                                left:57px;
                                top:12px;">
                                                37
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/37.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-38">
                                            <span
                                                style="position:absolute;
                                left:46px;
                                top:6px;">
                                                38
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/38.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-41">
                                            <span
                                                style="position:absolute;
                                left:13px;
                                top:35px;">
                                                41
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/41.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-42">
                                            <span
                                                style="position:absolute;
                                left:0px;
                                top:36px;">
                                                42
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/42.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-43">
                                            <span
                                                style="position:absolute;
                                left:-14px;
                                top:30px;">
                                                43
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/43.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-44">
                                            <span
                                                style="position:absolute;
                                left:-20px;
                                top:30px;">
                                                44
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/44.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-45">
                                            <span
                                                style="position:absolute;
                                left:-23px;
                                top:20px;">
                                                45
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/45.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-46">
                                            <span
                                                style="position:absolute;
                                left:-20px;
                                top:15px;">
                                                46
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/46.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-47">
                                            <span
                                                style="position:absolute;
                                left:-25px;
                                top:12px;">
                                                47
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/47.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-48">
                                            <span
                                                style="position:absolute;
                                left:-27px;
                                top:6px;">
                                                48
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/48.png') }}" class="simple-teeth" />
                                        </div>
                                    </div>
                                    <div id="children-teeth"
                                        style="{{ isset($examInvestigation) && $examInvestigation->jaw_type === 'adult' ? 'display: none;' : '' }}">
                                        <div class="teeth teeth-51">
                                            <span
                                                style="position:absolute;
                                left:7px;
                                top:-22px;">
                                                51
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/51.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-52">
                                            <span
                                                style="position:absolute;
                                left:-2px;
                                top:-23px;">
                                                52
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/52.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-53">
                                            <span
                                                style="position:absolute;
                                left:-14px;
                                top:-16px;">
                                                53
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/53.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-54">
                                            <span
                                                style="position:absolute;
                                left:-19px;
                                top:-3px;">
                                                54
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/54.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-55">
                                            <span
                                                style="position:absolute;
                                left:-20px;
                                top:0px;">
                                                55
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/55.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-61">
                                            <span
                                                style="position:absolute;
                                left:10px;
                                top:-22px;">
                                                61
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/61.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-62">
                                            <span
                                                style="position:absolute;
                                left:14px;
                                top:-23px;">
                                                62
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/62.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-63">
                                            <span
                                                style="position:absolute;
                                left:25px;
                                top:-16px;">
                                                63
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/63.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-64">
                                            <span
                                                style="position:absolute;
                                left:39px;
                                top:-3px;">
                                                64
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/64.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-65">
                                            <span
                                                style="position:absolute;
                                left:39px;
                                top:0px;">
                                                65
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/65.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-71">
                                            <span
                                                style="position:absolute;
                                left:7px;
                                top:25px;">
                                                71
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/71.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-72">
                                            <span
                                                style="position:absolute;
                                left:13px;
                                top:32px;">
                                                72
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/72.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-73">
                                            <span
                                                style="position:absolute;
                                left:30px;
                                top:27px;">
                                                73
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/73.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-74">
                                            <span
                                                style="position:absolute;
                                left:36px;
                                top:10px;">
                                                74
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/74.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-75">
                                            <span
                                                style="position:absolute;
                                left:37px;
                                top:5px;">
                                                75
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/75.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-81">
                                            <span
                                                style="position:absolute;
                                left:6px;
                                top:25px;">
                                                81
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/81.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-82">
                                            <span
                                                style="position:absolute;
                                left:-5px;
                                top:31px;">
                                                82
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/82.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-83">
                                            <span
                                                style="position:absolute;
                                left:-14px;
                                top:27px;">
                                                83
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/83.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-84">
                                            <span
                                                style="position:absolute;
                                left:-18px;
                                top:10px;">
                                                84
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/84.png') }}" class="simple-teeth" />
                                        </div>
                                        <div class="teeth teeth-85">
                                            <span
                                                style="position:absolute;
                                left:-20px;
                                top:5px;">
                                                85
                                            </span>
                                            <img src="{{ asset('assets/images/teeth/85.png') }}" class="simple-teeth" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>

        <div style="max-height:580px;" class="modal fade" id="exampleModal" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg-custom">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Teeth Analysis</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="toothIssueForm">
                            @if (isset($examInvestigation))
                                <input type="hidden" name="doctor_id" value="{{ $examInvestigation->doctor_id }}">
                                <input type="hidden" name="patient_id" value="{{ $examInvestigation->patient_id }}">
                            @endif
                            <input type="hidden" id="examination_id" name="examination_id"
                                value="{{ old('examination_id', isset($examInvestigation) ? $examInvestigation->id : '') }}">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <input type="hidden" id="tooth_number" name="tooth_number"
                                                value="{{ old('tooth_number') }}"
                                                class="form-control @error('tooth_number') is-invalid @enderror"
                                                placeholder="@lang('Name')">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header bg-info">
                                    <h3 class="card-title">Add Tooth issues</h3>
                                </div>
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table id="teeth_issues" class="table">
                                                    <thead class="bg-light">
                                                        <tr>
                                                            <th scope="col" class="custom-th-width-40">
                                                                @lang('Tooth Issue')</th>
                                                            <th scope="col" class="custom-th-width-60">
                                                                @lang('Description')</th>
                                                            <th scope="col" class="custom-white-space">
                                                                @lang('Add / Remove')</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <select name="tooth_issue[]"
                                                                    class="form-control tooth_issue" required>
                                                                    <option value="">--@lang('Select')--</option>
                                                                    <option value="Carious Class1">Carious Class1</option>
                                                                    <option value="Carious Class2">Carious Class2</option>
                                                                    <option value="Carious Class3">Carious Class3</option>
                                                                    <option value="Mobility Grade1">Mobility Grade1
                                                                    </option>
                                                                    <option value="Mobility Grade2">Mobility Grade2
                                                                    </option>
                                                                    <option value="Mobility Grade3">Mobility Grade3
                                                                    </option>
                                                                    <option value="BDR">BDR</option>
                                                                    <option value="Filled">Filled</option>
                                                                    <option value="Missing">Missing</option>
                                                                    <option value="FPD">FPD</option>
                                                                    <option value="RPD">RPD</option>
                                                                    <option value="Plaque & Calulus deposits">Plaque &
                                                                        Calulus deposits</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <textarea name="description[]" class="form-control" rows="1" placeholder="@lang('Description')"></textarea>
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-info m-add"><i
                                                                        class="fas fa-plus"></i></button>
                                                                <button type="button" class="btn btn-info m-remove"
                                                                    disabled><i class="fas fa-trash"></i></button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submits" class="btn btn-primary mb-3">Save</button>
                                </div>
                            </div>


                            <input type="hidden" name="record_id" id="record_id">
                            <input type="hidden" id="table_name" value="patient">
                            <input type="hidden" id="child_table" value="exam_investigations">


                            <div class="card">
                                <div class="card-header bg-info">
                                    <h3 class="card-title">Upload Documents/Pictures</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="col-md-12">
                                                <input type="file" id="teeth_files" name="teeth_files[]"
                                                    class="form-control file-upload" multiple
                                                    data-allowed-file-extensions="png jpg jpeg pdf"
                                                    data-max-file-size="2048K" />
                                                <p>{{ __('Max Size: 2048kb, Allowed Format: png, jpg, jpeg, pdf') }}</p>
                                                <div>
                                                    <div class="row col-12 justify-content-center" id="teethFileDivBody">
                                                        <div class="card d-flex flex-column ml-4 justify-content-start"
                                                            style="width:65px; height:70px; border:1px solid #00000036;">
                                                        </div>
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>@lang('File Name')</th>
                                                                    <th>@lang('Uploaded By')</th>
                                                                    <th>@lang('Uploaded At')</th>
                                                                    <th>@lang('Actions')</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="teethFileTableBody">
                                                                <!-- Teeth files will be populated here -->
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                @error('teeth_files')
                                                    <div class="error ambitious-red">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="row justify-content-end mb-2 pr-3">
                                        <button type="button" class="btn btn-primary" >Show Image
                                            Slider</button>
                                    </div> --}}
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal for Image Slider -->
        <div class="modal fade" id="attachmentsModal" tabindex="-1" role="dialog"
            aria-labelledby="carouselModalLabel">
            <div class="modal-dialog modal-lg" role="document" style="padding-top: 2%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="modal-title" style="font-weight:500;">Attached Images</span>
                        <button type="button" class="inner-close btn-info">&times;</button>
                    </div>
                    <div class="modal-body">
                        <!-- Carousel -->
                        <div id="imageCarousel" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators" id="carouselIndicators"></ol>
                            <div class="carousel-inner" id="carouselInner"></div>
                            <a class="carousel-control-prev" href="#imageCarousel" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#imageCarousel" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


        <script>
            var getFilesUrl = "{{ route('get-files', $examInvestigation->id) }}";
            var uploadFilesUrl = "{{ route('upload-file') }}";
            var deleteFilesUrl = "{{ route('delete-file') }}";
            var baseUrl = '{{ asset('') }}';
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const insuranceVerifiedCheckbox = document.getElementById('insuranceVerifiedCheckbox');
    
                insuranceVerifiedCheckbox.addEventListener('change', function () {
                    const insurance_verified = this.checked ? 'yes' : 'no';
                    $.ajax({
                        url: '{{ route("updateInsuranceVerified", $examInvestigation->id) }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            insurance_verified: insurance_verified
                        },
                        success: function (response) {
                            if (response.success) {
                                alert('Insurance status updated successfully.');
                            } else {
                                alert('Failed to update insurance status.');
                            }
                        },
                        error: function (xhr) {
                            alert('Error occurred while updating insurance status: ' + xhr.responseJSON.message);
                        }
                    });
                });
            });
    
            function updateCheckboxVisibility() {
                const tableBody = $('#insuranceCardTableBody');
                const checkboxContainer = $('.form-check');
    
    
          // Check if the table body has any rows
                if (tableBody.find('tr').length > 0) {
                    checkboxContainer.show();
                }
            }
            $(document).ready(function() {
                // Attach change event to file input
                $('#insurance_card').on('change', function() {
                    // Set a timeout to call updateCheckboxVisibility after 500ms
                    setTimeout(function() {
                        console.log("Before Uploading File at " + new Date().toLocaleString());
                        updateCheckboxVisibility();
                        console.log("After Uploading File at " + new Date().toLocaleString());
                    }, 3000);
                });
    
                // Initial call to set the checkbox visibility on page load
                updateCheckboxVisibility();
            });
        </script>



        <script>
            $(document).ready(function() {
                // Checkbox change event
                $('#intra_oral_check').on('change', function() {
                    if ($(this).is(':checked')) {
                        $('#intra_oral_id').attr('disabled', true);
                    } else {
                        $('#intra_oral_id').attr('disabled', false); 
                    }
                });
        
                // Submit form via AJAX
                $('#intraOral').on('submit', function(e) {
                    e.preventDefault(); 
        
                    var formData = $(this).serialize();
        
                    $.ajax({
                        type: "POST",
                        url: '{{ URL::to('extraOral') }}', 
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            alert('Record Successfully Saved');
                            $('#intra_oral_id')[0].reset();
                            $('#intra_oral_id').attr('disabled', false); 
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            alert('Error saving record. Please try again.');
                        }
                    });
                });
            });
        </script>

        <script>
            $(document).ready(function() {
                // Checkbox change event
                $('#check_hard_tissue_id').on('change', function() {
                    if ($(this).is(':checked')) {
                        $('#hard_tissue_id').attr('disabled', true);
                    } else {
                        $('#hard_tissue_id').attr('disabled', false); 
                    }
                });
                $('#hardtissue').on('submit', function(e) {
                    e.preventDefault(); 
                    var formData = $(this).serialize();
                    $.ajax({
                        type: "POST",
                        url: '{{ URL::to('hardTissue') }}', 
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            alert('Record Successfully Saved');
                            $('#hard_tissue_id')[0].reset();
                            $('#hard_tissue_id').attr('disabled', false); 
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            alert('Error saving record. Please try again.');
                        }
                    });
                });
            });
        </script>


        <script>
            $(document).ready(function() {
                // Checkbox change event
                $('#check_soft_tissue').on('change', function() {
                    if ($(this).is(':checked')) {
                        $('#soft_tissue_id').attr('disabled', true);
                    } else {
                        $('#soft_tissue_id').attr('disabled', false); 
                    }
                });
                $('#softtissue').on('submit', function(e) {
                    e.preventDefault(); 
                    var formData = $(this).serialize();
                    $.ajax({
                        type: "POST",
                        url: '{{ URL::to('softTissue') }}', 
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            alert('Record Successfully Saved');
                            $('#soft_tissue_id')[0].reset();
                            $('#soft_tissue_id').attr('disabled', false); 
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            alert('Error saving record. Please try again.');
                        }
                    });
                });
            });
        </script>

        <script>
            $(document).ready(function() {
                // Checkbox change event
                $('#checkuser').on('change', function() {
                    if ($(this).is(':checked')) {
                        $('#extra_oral').attr('disabled', true);
                    } else {
                        $('#extra_oral').attr('disabled', false); 
                    }
                });
        
                // Submit form via AJAX
                $('#extraOral').on('submit', function(e) {
                    e.preventDefault(); 
        
                    var formData = $(this).serialize();
        
                    $.ajax({
                        type: "POST",
                        url: '{{ URL::to('extraOral') }}', 
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            alert('Record Successfully Saved');
                            $('#extra_oral')[0].reset();
                            $('#extra_oral').attr('disabled', false); 
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            alert('Error saving record. Please try again.');
                        }
                    });
                });
            });
        </script>

        <script>
            $(document).ready(function() {
                // Checkbox change event
                $('#check').on('change', function() {
                    if ($(this).is(':checked')) {
                        $('#historyChiefComplaint').attr('disabled', true);  // Disable dropdown
                    } else {
                        $('#historyChiefComplaint').attr('disabled', false);  // Enable dropdown
                    }
                });
        
                // Submit form via AJAX
                $('#chiefComplaintForm').on('submit', function(e) {
                    e.preventDefault();  // Prevent form submission
        
                    var formData = $(this).serialize();
        
                    $.ajax({
                        type: "POST",
                        url: '{{ URL::to('storechief') }}',  // Use the correct URL for submission
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            alert('Record Successfully Saved');
                            $('#chiefComplaintForm')[0].reset();
                            $('#historyChiefComplaint').attr('disabled', false);  // Reset dropdown to enabled state
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            alert('Error saving record. Please try again.');
                        }
                    });
                });
            });
        </script>
        
        
        
        

        <script>
            var uploadFilesUrl = "{{ route('upload-file') }}";
            var deleteFilesUrl = "{{ route('delete-files') }}";
            console.log('This is Upload File Url', uploadFilesUrl);
            console.log("Delete File Url", deleteFilesUrl);
        </script>
        <script>
            // Initialize the carousel when the modal is shown
            $('#imageSliderModal').on('shown.bs.modal', function() {
                $('#imageCarousel').carousel({
                    interval: 2000 // Optional: Set the interval between slides (in milliseconds)
                });
            });
        </script>

        <script>
            var baseUrl = '{{ asset('') }}';
            console.log("This is the Base Url: ", baseUrl)
            var selected_tooth_array = [];
            document.addEventListener('DOMContentLoaded', function() {

                const checkboxes = document.querySelectorAll('.exam-investigation-checkboxes input[type="checkbox"]');
                const adultTeethDiv = document.getElementById('adult-teeth');
                const childrenTeethDiv = document.getElementById('children-teeth');
                const examInvestigationId = document.getElementById('examination_id').value;
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                window.disableCheckboxes = function() {
                    checkboxes.forEach(cb => {
                        cb.disabled = true;
                    });
                }
                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        if (this.checked) {
                            checkboxes.forEach(cb => {
                                if (cb !== this) {
                                    cb.checked = false;
                                }
                            });
                            if (this.id === 'check-adult') {
                                adultTeethDiv.style.display = 'block';
                                childrenTeethDiv.style.display = 'none';
                            } else if (this.id === 'check-children') {
                                adultTeethDiv.style.display = 'none';
                                childrenTeethDiv.style.display = 'block';
                            } else {
                                adultTeethDiv.style.display = 'block';
                                childrenTeethDiv.style.display = 'block';
                            }
                            // disableCheckboxes();

                            $.ajax({
                                url: '{{ route('exam-investigations.updatejawtype') }}',
                                method: 'POST',
                                data: {
                                    _token: csrfToken,
                                    id: examInvestigationId,
                                    jaw_type: this.value
                                },
                                success: function(response) {
                                    console.log('Jaw type updated successfully');
                                },
                                error: function(xhr) {
                                    console.error('Error updating jaw type:', xhr);
                                }
                            });

                            // disableCheckboxes();
                        }
                    });
                });


                var examination_id = $('#exampleModal #examination_id').val();

                if (examination_id) { // Check if procedure_id is not null or empty
                    $.ajax({
                        url: '{{ url('/patient-teeth-issues') }}/' + examination_id,
                        type: 'GET',
                        success: function(response) {
                            console.log(response);
                            markSelectedTeeth(response)
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching teeth issues:', error);
                        }
                    });
                } else {
                    console.log('No Examination ID provided. Skipping AJAX call.');
                }

                document.querySelectorAll('input[name="optradio"]').forEach(function(radio) {
                    radio.addEventListener('change', function() {
                        if (this.value === 'single') {
                            document.querySelector('.area-bulk-selection').style.display = 'none';
                        } else if (this.value === 'bulk') {
                            document.querySelector('.area-bulk-selection').style.display = 'block';
                        }
                    });
                });
            });

            $(document).ready(function() {
                window.escapeFileName = function(fileName) {
                    return fileName.replace(/[ .\-()]/g, '_');
                };

                let tooth = document.querySelectorAll('.teeth');
                tooth.forEach(function(teeth) {
                    teeth.addEventListener('click', function() {
                        let selectionType = document.querySelector('input[name="optradio"]:checked')
                            .value;
                        if (selectionType === 'single') {
                            handleSingleSelection(this);
                        } else {
                            handleBulkSelection(this);
                        }
                    });
                });

                function handleSingleSelection(teethElement) {
                    let teeth_number = getTeethNumber(teethElement.className);
                    var doctorId = $('#doctor_id').val();
                    var patientId = $('#patient_id').val();
                    var Childtable = $('#child_table').val();

                    // Set the teeth number in the modal input with specific ID
                    $('#tooth_number').val(teeth_number);
                    $('#exampleModal #doctor_id').val(doctorId);
                    $('#exampleModal #patient_id').val(patientId);
                    $('#exampleModal #record_id').val(patientId);
                    var examinationId = $('#exampleModal #examination_id').val();
                    $('#exampleModalLabel').text('Teeth Analysis # ' + teeth_number);

                    // Show the modal
                    $('#exampleModal').modal('show');
                    $.ajax({
                        url: '{{ url('/patient-teeth-issues') }}/' + examinationId + '/' + patientId + '/' +
                            teeth_number,
                        type: 'GET',
                        success: function(response) {
                            populateToothIssues(response);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching tooth issues:', error);
                        }

                    });
                }

                function handleBulkSelection(teethElement) {
                    let teeth_number = getTeethNumber(teethElement.className);
                    let img = teethElement.querySelector('img');
                    if (img.classList.contains('simple-teeth')) {
                        img.classList.remove('simple-teeth');
                        img.classList.add('red-teeth');
                        selected_tooth_array.push(teeth_number)
                    } else {
                        img.classList.remove('red-teeth');
                        img.classList.add('simple-teeth');
                        let teeth_index = selected_tooth_array.indexOf(teeth_number);
                        if (teeth_index !== -1) {
                            selected_tooth_array.splice(teeth_index, 1);
                        }
                    }

                    console.log(selected_tooth_array);
                }

                $('#teethForm').on('submit', function(event) {
                    event.preventDefault();

                    var issues = [];
                    $('#teeth_issues tbody tr').each(function() {
                        var toothIssue = $(this).find('select[name="tooth_issue[]"]').val();
                        var description = $(this).find('textarea[name="description[]"]').val();
                        if (toothIssue) {
                            issues.push({
                                tooth_issue: toothIssue,
                                description: description
                            });
                        }
                    });

                    var data = {
                        doctor_id: $('input[name="doctor_id"]').val(),
                        patient_id: $('input[name="patient_id"]').val(),
                        examination_id: $('input[name="examination_id"]').val(),
                        teeth: selected_tooth_array,
                        issues: issues
                    };

                    $.ajax({
                        url: "{{ route('patient-teeths.store') }}",
                        type: 'POST',
                        data: JSON.stringify(data),
                        contentType: 'application/json',
                        success: function(response) {
                            if (response.success) {
                                alert('Teeth issues saved successfully!');
                                markSelectedTeeth(selected_tooth_array);

                                // Uncheck all checkboxes and reset selected teeth

                                // Reset the tooth issues table
                                $('#teeth_issues tbody tr').not(':first').remove();
                                $('#teeth_issues tbody tr:first').find(
                                    'select[name="tooth_issue[]"]').val('');
                                $('#teeth_issues tbody tr:first').find(
                                    'textarea[name="description[]"]').val('');
                            } else {
                                alert('Error saving teeth issues.');
                            }
                        },
                        error: function(xhr, status, error) {
                            alert('Error saving teeth issues: ' + error);
                        }
                    });
                });

                window.getTeethNumber = function(className) {
                    let match = className.match(/\bteeth-(\d+)\b/);
                    return match ? match[1] : null;
                }

                window.populateToothIssues = function(toothIssues) {
                    var newRow = new Array();
                    for (var i = 0; i < toothIssues.length; i++) {
                        var currentIssue = toothIssues[i];
                        // Verify data format (add logging for debugging)
                        if (!currentIssue.hasOwnProperty('tooth_issue') || !currentIssue.hasOwnProperty(
                                'description')) {
                            console.error('Invalid tooth issue data format:', currentIssue);
                            continue; // Skip to next iteration if format is wrong
                        }

                        newRow.push($('#teeth_issues tbody tr').first().clone());
                        //var newRow[i] = $('#teeth_issues tbody tr').first().clone();

                        if (i == 0) {
                            $('#teeth_issues tbody').empty();
                        }

                        // Clear existing data in the cloned row
                        newRow[i].find('select[name="tooth_issue[]"]').val('').trigger('change');
                        newRow[i].find('textarea[name="description[]"]').val('');

                        // Set values in the new row
                        newRow[i].find('select[name="tooth_issue[]"]').val(currentIssue.tooth_issue).trigger(
                            'change');
                        newRow[i].find('textarea[name="description[]"]').val(currentIssue.description);
                        newRow[i].find('.m-remove').prop('disabled', false);

                        // Append the new row
                        //$('#teeth_issues tbody').empty();
                        $('#teeth_issues tbody').append(newRow[i]);
                        console.log("Doneeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee")

                    }

                }

            });

            // function populateTeethFiles(response) {
            //     $('#teethFileDivBody').html('');
            //     if (response.files) {
            //         response.files.forEach(file => {
            //             var filePath = baseUrl + '/storage/uploads/patient/' + $('#record_id').val() +
            //                 '/exam_investigations/' + $('#examination_id').val() + '/' + $('#tooth_number').val() +
            //                 '/' + file.file_name;
            //             console.log("This is file Path", filePath);
            //             $('#teethFileDivBody').append(
            //                 `

    //                 <div id="file-row-${escapeFileName(file.file_name)}" class="card d-flex flex-column ml-4 justify-content-start" style="width:65px; height:75px; border:1px solid #00000036;">
    //             <div class="card-image d-flex flex-row justify-content-center"style="height:50px;">
    //                 <img src="${filePath}" style="height:inherit; width:90%;" alt="">
    //             </div>

    //           <div class="d-flex flex-row justify-content-between p-0">
    //            <span class="btn btn-info my-1 ml-1" style="width:16px !important; height:16px; font-size:10px;
    //            text-align:center; align-content:center; padding:0px;">
    //                 <a style="color:#fff" href="${filePath}" download><i class="fas fa-download"></i></a>
    //             </span>
    //             <span onclick="confirmDeleteTeethFile('${file.file_name}', 'teeth_files', '${$('#record_id').val()}', 'teethFileDivBody')" class="btn btn-danger my-1  mr-1"
    //             style="width:16px !important; height:16px; font-size:10px;
    //                 text-align:center; align-content:center; padding:0px;">
    //                 <i class="fas fa-trash-alt"style="color:#fff"></i>
    //             </span>
    //           </div>
    //         </div>
    //         `
            //             );
            //         });

            //         if (response.files.length === 0) {
            //             $('#teethFileDivBody').append('<div><div>@lang('No files found.')</div></div>');
            //         }
            //     }
            // }
            function populateTeethFiles(response) {
                $('#teethFileDivBody').html('');
                if (response.files) {
                    response.files.forEach(file => {
                        var filePath = baseUrl + '/storage/uploads/patient/' + $('#record_id').val() +
                            '/exam_investigations/' + $('#examination_id').val() + '/' + $('#tooth_number').val() +
                            '/' + file.file_name;
                        console.log("This is file Path", filePath);
                        $('#teethFileDivBody').append(
                            `
                <div id="file-row-${escapeFileName(file.file_name)}" class="card d-flex flex-column ml-4 justify-content-start" style="width:65px; height:75px; border:1px solid #00000036;">
                    <div class="card-image d-flex flex-row justify-content-center" style="height:50px;">
                        <img src="${filePath}" style="height:inherit; width:90%;" alt="" onclick="setEscapedFileName('${file.file_name}')">
                    </div>
                    <div class="d-flex flex-row justify-content-between p-0">
                        <span class="btn btn-info my-1 ml-1" style="width:16px !important; height:16px; font-size:10px; text-align:center; align-content:center; padding:0px;">
                            <a style="color:#fff" href="${filePath}" download><i class="fas fa-download"></i></a>
                        </span>
                        <span onclick="confirmDeleteTeethFile('${file.file_name}', 'teeth_files', '${$('#record_id').val()}', 'teethFileDivBody')" class="btn btn-danger my-1  mr-1" style="width:16px !important; height:16px; font-size:10px; text-align:center; align-content:center; padding:0px;">
                            <i class="fas fa-trash-alt" style="color:#fff"></i>
                        </span>
                    </div>
                </div>
                `
                        );
                    });

                    if (response.files.length > 0) {
                        disableCheckboxes();
                    }

                    if (response.files.length === 0) {
                        $('#teethFileDivBody').append('<div><div>@lang('No files found.')</div></div>');
                    }
                }
            }
            let escapedFileName = ''; // Define the variable to store the file name

            function setEscapedFileName(fileName) {
                escapedFileName = fileName;
                var examinationId = $('#exampleModal #examination_id').val();
                var teethNumber = $('#tooth_number').val();
                fetchImages(examinationId, teethNumber, escapedFileName);
            }

            $('#openSliderButton').on('click', function() {
                var examinationId = $('#exampleModal #examination_id').val();
                var teethNumber = $('#tooth_number').val();
                fetchImages(examinationId, teethNumber, escapedFileName);
            });

            function fetchImages(examinationId, teethNumber, escapedFileName) {
                $.ajax({
                    url: '{{ route('get-teeth-files') }}',
                    type: 'GET',
                    data: {
                        examination_id: examinationId,
                        tooth_number: teethNumber
                    },
                    success: function(response) {
                        if (response.files && response.files.length > 0) {
                            populateImageSlider(response.files, escapedFileName);
                            $('#attachmentsModal').modal('show');
                        } else {
                            alert('No images found.');
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error fetching images: ' + error);
                    }
                });
            }

            function populateImageSlider(files, escapedFileName) {
                var indicators = '';
                var innerItems = '';

                var basePath = baseUrl + 'storage/uploads/patient/' + $('#record_id').val() + '/exam_investigations/' + $(
                    '#examination_id').val() + '/' + $('#tooth_number').val() + '/';

                files.forEach((file, index) => {
                    var isActive = file.file_name === escapedFileName ? 'active' : '';

                    indicators += `<li data-target="#imageCarousel" data-slide-to="${index}" class="${isActive}"></li>`;

                    innerItems += `
            <div class="carousel-item ${isActive}">
                <img src="${basePath + file.file_name}" alt="Image ${index + 1}" style="width:100%;height:350px"/>
            </div>`;
                });

                $('#carouselIndicators').html(indicators);
                $('#carouselInner').html(innerItems);
            }


            window.getFiles = function() {
                var examinationId = $('#exampleModal #examination_id').val();
                var teethNumber = $('#tooth_number').val();

                $.ajax({
                    url: '{{ route('get-teeth-files') }}',
                    type: 'GET',
                    data: {
                        examination_id: examinationId,
                        tooth_number: teethNumber
                    },
                    success: function(response) {
                        populateTeethFiles(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching teeth files:', error);
                    }
                });
            }

            // Initial fetch of teeth files when modal is opened (optional)

            $('#exampleModal').on('shown.bs.modal', function() {
                getFiles();
            });

            $('#exampleModal').on('hidden.bs.modal', function() {
                // Clone the first template row
                var newRow = $('#teeth_issues tbody tr:first').clone();

                // Reset values in the cloned row
                newRow.find('select[name="tooth_issue[]"]').val('');
                newRow.find('textarea[name="description[]"]').val('');
                newRow.find('.m-remove').prop('disabled', true); // Enable remove button

                // Replace existing content with the cloned and cleared row
                $('#teeth_issues tbody').html(newRow);
            });

            function markSelectedTeeth(toothNumbers) {
                if (!Array.isArray(toothNumbers)) {
                    toothNumbers = [toothNumbers];
                }

                toothNumbers.forEach(function(toothNumber) {
                    const toothElement = document.querySelector(`.teeth.teeth-${toothNumber}`);
                    if (toothElement) {
                        const imgElement = toothElement.querySelector('img');
                        if (imgElement && imgElement.classList.contains('simple-teeth')) {
                            imgElement.classList.remove('simple-teeth');
                            imgElement.classList.add('red-teeth');
                        }
                        if (!selected_tooth_array.includes(toothNumber)) {
                            selected_tooth_array.push(toothNumber);
                        }
                    }
                });
            }



            // Initially set the visibility of sections based on the selected radio button



            // Initialize select2 for the initial row

            // Disable remove button on initial row
            $('.m-remove').prop('disabled', true);

            // Add button click event handler
            $(document).on('click', '.m-add', function() {
                // Clone the last row
                const newRow = $(this).closest('tr').clone();

                // Clear values in the new row (except for select if pre-selecting is desired)
                newRow.find('input[type="text"], textarea').val('');
                newRow.find('select').val(null).trigger('change'); // Reset select2

                // Enable remove button in the newly added row
                newRow.find('.m-remove').prop('disabled', false);

                // Append the new row to the table body
                $(this).closest('tbody').append(newRow);

                // Re-initialize select2 for the new row
            });

            // Remove button click event handler
            $(document).on('click', '.m-remove', function() {
                $(this).closest('tr').remove();

                // If only one row remains, disable the remove button in that row
                if ($('.m-remove').length === 1) {
                    $('.m-remove').prop('disabled', true);
                }
            });

            $('#toothIssueForm').submit(function(event) {
                event.preventDefault(); // Prevent default form submission

                // Serialize form data
                var formData = $(this).serialize();

                // AJAX request
                $.ajax({
                    url: "{{ route('patient-teeths.store') }}", // Update with your route
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        if (response.data) {
                            console.log(response.data.tooth_number);
                            markSelectedTeeth(response.data.tooth_number);
                        }
                        // Handle success response (optional)
                        console.log(response);
                        $('#exampleModal').modal('hide'); // Hide the modal after successful submission
                        disableCheckboxes();
                        // Optionally show a success message or redirect
                    },
                    error: function(xhr, status, error) {
                        // Handle error response (optional)
                        console.error(xhr.responseText);
                        // Optionally display an error message
                    }
                });
            });


            $('#patient_id').on('change', function() {
                var patientId = $(this).val();
                $.ajax({
                    url: '{{ route('fetch.appointments') }}',
                    type: 'GET',
                    data: {
                        patient_id: patientId
                    },
                    success: function(data) {
                        var appointments = data.appointments;
                        var options = '<option value="" disabled selected>Select Any Appointment</option>';
                        $.each(appointments, function(index, appointment) {
                            options += '<option value="' + appointment.id + '">' + appointment
                                .appointment_number + '</option>';
                        });
                        $('#patient_appointment_id').html(options);
                    },
                    error: function() {
                        alert('Failed to fetch appointments. Please try again.');
                    }
                });
            });

            $('#patient_appointment_id').on('change', function() {
                var patientappointmentId = $(this).val();
                if (patientappointmentId) {
                    $.ajax({
                        url: '{{ route('fetch.doctors') }}',
                        type: 'GET',
                        data: {
                            patient_appointment_id: patientappointmentId
                        },
                        success: function(data) {
                            var doctors = data.doctors;
                            var options = '';
                            $.each(doctors, function(index, doctor) {
                                options += '<option value="' + doctor.id + '">' + doctor.name +
                                    '</option>';
                            });
                            $('#doctor_id').html(options);
                        },
                        error: function(xhr, status, error) {
                            console.error('Failed to fetch doctors:', error);
                            $('#doctor_id').html(
                                '<option value="" disabled selected>No doctors available</option>');
                        }
                    });
                } else {
                    $('#doctor_id').html('<option value="" disabled selected>Select Doctor</option>');
                }
            });



            window.confirmDeleteTeethFile = function(fileName, fileType, recordId, tableBodyId) {
                if (confirm('Are you sure you want to delete this file?')) {
                    deleteTeethFile(fileName, fileType, recordId, 'patient', tableBodyId);
                }
            };



            window.deleteTeethFile = function(fileName, fileType, recordId, table_name, tableBodyId) {
                var teethNumber = $('#tooth_number').val();
                var examinationId = $('#exampleModal #examination_id').val();
                var child_table = $('#child_table').val();
                console.log('fileName: ' + fileName);
                console.log('fileType: ' + fileType);
                console.log('recordId: ' + recordId);
                console.log('table_name: ' + table_name);
                console.log('tableBodyId: ' + tableBodyId);
                console.log('teethNumber: ' + teethNumber);
                console.log('examinationId: ' + examinationId);
                console.log('child_table: ' + child_table);
                $.ajax({
                    url: deleteFilesUrl,
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        fileName: fileName,
                        fileType: fileType,
                        recordId: recordId,
                        table_name: table_name,
                        teethNumber: teethNumber,
                        child_table: child_table,
                        examinationId: examinationId,
                    },
                    success: function(response) {
                        if (response.success) {
                            var escapedFileName = escapeFileName(fileName);
                            $(`#${tableBodyId}`).find(`#file-row-${escapedFileName}`).remove();
                            const fileElement = document.querySelector(`#file-row-${escapedFileName}`);
                            console.log('FileName: ' + fileElement);
                        } else {
                            alert('Error deleting file: ' + response.error);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error deleting file: ' + error);
                    }
                });
            };

            // Inner Modal close issue
            $('.inner-close').click(function(teethElement) {
                $('#attachmentsModal').modal('hide');
                console.log("Inner Modal")
                var patientId = $('#patient_id').val();
                var tooth = $('#exampleModal #tooth_number').val();
                var examinationId = $('#exampleModal #examination_id').val();
                //   let teeth_number = getTeethNumber(teethElement.className);
                $.ajax({
                    url: '{{ url('/patient-teeth-issues') }}/' + examinationId + '/' + patientId + '/' +
                        tooth,
                    type: 'GET',
                    success: function(response) {
                        window.setTimeout(function() {
                            populateToothIssues(response);
                        }, 200);

                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching tooth issues:', error);
                    }

                });
            });
        </script>
    @endsection
