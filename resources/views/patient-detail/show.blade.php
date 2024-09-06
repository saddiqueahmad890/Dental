@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <input type="hidden" id="record_id" value="{{ $patientDetail->id }}">
                <input type="hidden" id="table_name" value="patient">

                <div class="col-sm-6">
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('patient-details.index') }}">@lang('Patient')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('Patient Info')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">

        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-info d-flex">
                    <div class="profile-pic2">
                        <img class="profile-user-img img-fluid img-circle" src="{{ asset('storage/' . $profilePicture) }}"
                            alt="" />
                    </div>
                    <h3 class="card-title ml-2 mt-2">@lang('Patient Info') - {{ $patientDetail->name }}</h3>
                    @can('patient-detail-update')
                        <div class="card-tools" style="position: absolute;right: 28px;">
                            <a href="{{ route('patient-details.edit', $patientDetail) }}"
                                class="btn btn-info">@lang('Edit')</a>
                        </div>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="bg-custom">
                        <div class="row col-12 m-0 p-0">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="name">@lang('Name')</label>
                                    <p>{{ $patientDetail->name }}</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="cnic">@lang('MRN Number')</label>
                                    <p>{!! optional($patientDetail->patientDetails)->mrn_number ?? ' ' !!}</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="email">@lang('Email')</label>
                                    <p>{{ $patientDetail->email }}</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="phone">@lang('Phone')</label>
                                    <p>{{ $patientDetail->phone }}</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="gender">@lang('Gender')</label>
                                    <p>{{ ucfirst($patientDetail->gender) }}</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="cnic">@lang('CNIC')</label>
                                    <p>{!! $patientDetail->patientDetails->cnic ?? ' ' !!}</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="blood_group">@lang('Blood Group')</label>
                                    <p>{{ $patientDetail->ddbloodgroup->name ?? ' ' }}</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="date_of_birth">@lang('Date of Birth')</label>
                                    <p>{{ $patientDetail->date_of_birth ? \Carbon\Carbon::parse($patientDetail->date_of_birth)->format('d-M-Y') : '-' }}</p>
    
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="marital_status">@lang('Marital Status')</label>
                                    <p>{!! $patientDetail->patientDetails->maritalStatus->name ?? '-' !!}</p>
    
                                </div>
                            </div>
    
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="credit_balance">@lang('Credit Balance')</label>
                                    <p>{!! $patientDetail->patientDetails->credit_balance ?? ' ' !!}</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="insurance_provider">@lang('Insurance Company')</label>
                                    <p>{!! $patientDetail->patientDetails->insurance->name ?? ' ' !!}</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="status">@lang('Status')</label>
                                    <p>
                                        @if ($patientDetail->status == 1)
                                            <span class="badge badge-pill badge-success">@lang('Active')</span>
                                        @else
                                            <span class="badge badge-pill badge-danger">@lang('Inactive')</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="area">@lang('Area')</label>
                                    <p>{!! $patientDetail->patientDetails->area ?? ' ' !!}</p>
                                </div>
                            </div>
    
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="city">@lang('City')</label>
                                    <p>{!! $patientDetail->patientDetails->city ?? ' ' !!}</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="address">@lang('Address')</label>
                                    <p>{{ $patientDetail->address }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <div class="card">
        <div class="card-header bg-info">
            <h3 class="card-title">CNIC</h3>
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
                            <tbody id="cnicFileTableBody" class="fileTableBody"></tbody>
                            <!-- CNIC files will be loaded here via AJAX -->
                        </tbody>
                        </table>
                    </div>
                    @error('cnic_file')
                        <div class="error ambitious-red">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="card" @if(isset($patientDetail->patientDetails) && $patientDetail->patientDetails->insurance_provider_id !== null) style="display: block;" @else style="display: none;" @endif>
        <div class="card-header bg-info">
            <h3 class="card-title">Upload Insurance Documents</h3>
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
                            <tbody id="insuranceCardTableBody" class="fileTableBody"></tbody>
                            <!-- Insurance files will be loaded here via AJAX -->
                        </tbody>
                        </table>
                        <div class="form-check" @if($insuranceFiles > 0) style="display: block;" @else style="display: none;" @endif>
                            <label class="form-check-label">
                                {{ __('Insurance Verified') }}
                            </label>
                        </div>
                    </div>
                    @error('insurance_card')
                        <div class="error ambitious-red">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-info">
            <h3 class="card-title">Other Documents</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="col-md-12">
                        {{-- <input id="other_files" name="other_files[]" type="file" multiple
                            data-allowed-file-extensions="png jpg jpeg pdf xml txt doc docx mp4"
                            data-max-file-size="2048K" /> --}}

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>@lang('File Name')</th>
                                    <th>@lang('Uploaded By')</th>
                                    <th>@lang('Upload Date')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody id="otherFilesTableBody" class="fileTableBody"></tbody>
                            <!-- Other files will be loaded here via AJAX -->
                        </tbody>
                        </table>
                    </div>
                    @error('other_files')
                        <div class="error ambitious-red">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>
    </div>


















    <div class="card">

        <div class="card-header bg-info">
            {{ $patientDetail->name }}'s history
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
                        <h3>@lang('Medical History of') {{ $patientDetail->name }}</h3>
                    </div>
                    <hr>
                    <p>
                    <div class="row">
                        @foreach ($patientMedicalHistories as $item)
                            <div class="col-xl-3 p-3">
                                <div class="form-group m-0">
                                    <label>{{ $item->ddMedicalHistory->title ?? ' ' }}</label>
                                    <p>{{ $item->comments }}</p>
                                </div>
                            </div>
                        @endforeach
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
                        <h3>@lang('Drug History of') {{ $patientDetail->name }}</h3>
                    </div>
                    <hr>
                    <p>
                    <div class="row">
                        @foreach ($patientDrugHistories as $item)
                            <div class="col-xl-3 p-3">
                                <div class="form-group m-0">
                                    <label>{{ $item->ddDrugHistory->title }}</label>
                                    <p>{{ $item->comments }}</p>
                                </div>
                            </div>
                        @endforeach
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
                        <h3>@lang('Social History of') {{ $patientDetail->name }}</h3>
                    </div>
                    <hr>
                    <p>
                    <div class="row">
                        @foreach ($patientSocialHistories as $item)
                            <div class="col-xl-3 p-3">
                                <div class="form-group m-0">
                                    <label>{{ $item->ddSocialHistory->title ?? '-' }}</label>
                                    <p>{{ $item->comments }}</p>
                                </div>
                            </div>
                        @endforeach
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
                        <h3>@lang('Dental History of') {{ $patientDetail->name }}</h3>
                    </div>
                    <hr>
                    <p>
                    <div class="row">
                        @foreach ($patientDentalHistories as $item)
                            <div class="col-xl-3 p-3">
                                <div class="form-group m-0">
                                    <label>{{ $item->ddDentalHistory->title ?? '-' }}</label>
                                    <p>{{ $item->comments }}</p>
                                </div>
                            </div>
                        @endforeach
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



    <div class="card">

        <div class="card-header bg-info">
            Related Modules
        </div>
        <div class="card-body">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#tab-appointments" role="tab"
                        aria-controls="home" aria-selected="true">Appointments</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#tab-exam-investigations"
                        role="tab" aria-controls="profile" aria-selected="false">Exam & Investigations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="messages-tab" data-toggle="tab" href="#tab-treatment-plans" role="tab"
                        aria-controls="messages" aria-selected="false">Treatment Plans</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="messages-tab" data-toggle="tab" href="#tab-prescriptions" role="tab"
                        aria-controls="messages" aria-selected="false">Prescriptions</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" id="settings-tab" data-toggle="tab" href="#tab-invoices" role="tab"
                        aria-controls="settings" aria-selected="false">Invoices</a>
                </li>
            </ul>

            <!-- Tab content -->
            <div class="tab-content" id="myTabContent"
                style="    border-left: 1px solid #ccc;    border: 1px solid #ccc;    margin-top: -1px;    padding: 20px;">
                <div class="tab-pane fade show active" id="tab-appointments" role="tabpanel" aria-labelledby="home-tab">
                    <h3>Appointments</h3>
                    <table class="table table-striped custom-table" id="laravel_datatable">
                        <thead>
                            <tr>
                                <th>@lang('Appointment Number')</th>
                                <th>@lang('Doctor')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Problem')</th>
                                <th>@lang('Start Time')</th>
                                <th>@lang('End Time')</th>
                                <th>@lang('Dated')</th>
                            </tr>
                        </thead>
                        <tbody>
                </div>

                @foreach ($patientAppointments as $patientAppointment)
                    <tr>
                        <td>
                            <a href="{{ route('patient-appointments.show', $patientAppointment->id) }}"
                                class="text-decoration-underline">
                                {{ $patientAppointment->appointment_number }}
                            </a>
                        </td>
                        <td>{{ $patientAppointment->doctor->name }}</td>
                        <td>{{ isset($patientAppointment->appointmentstatus->name) ? $patientAppointment->appointmentstatus->name : '-' }}
                        </td>
                        <td>{{ isset($patientAppointment->problem) ? $patientAppointment->problem : '-' }}</td>
                        <td>{{ $patientAppointment->start_time }}</td>
                        <td>{{ $patientAppointment->end_time }}</td>
                        <td>{{ $patientAppointment->appointment_date }}</td>
                    </tr>
                @endforeach


                </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="tab-exam-investigations" role="tabpanel" aria-labelledby="profile-tab">
                <h3>Exam Investigations</h3>
                <table class="table table-striped custom-table" id="laravel_datatable">
                    <thead>
                        <tr>
                            <th>@lang('Examination Number')</th>
                            <th>@lang('Appointment Number')</th>
                            <th>@lang('Doctor')</th>
                            <th>@lang('Comments')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($examInvestigations as $examInvestigation)
                            <tr>

                                <td>
                                    <a href="{{ route('exam-investigations.show', $examInvestigation->id) }}"
                                        class="text-decoration-underline">
                                        {{ $examInvestigation->examination_number }}</a>
                                </td>
                                <td>{{ isset($examInvestigation->PatientAppointment->appointment_number) ? $examInvestigation->PatientAppointment->appointment_number : '-' }}
                                </td>
                                <td>{{ isset($examInvestigation->doctor->name) ? $examInvestigation->doctor->name : '-' }}
                                </td>
                                <td>{{ isset($examInvestigation->comments) ? $examInvestigation->comments : '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
            <div class="tab-pane fade" id="tab-treatment-plans" role="tabpanel" aria-labelledby="messages-tab">
                <h3>Treatment Plans</h3>
                <table class="table table-striped custom-table" id="laravel_datatable">
                    <thead>
                        <tr>
                            <th>@lang('Treatment Plan Number')</th>
                            <th>@lang('Examination Number')</th>
                            <th>@lang('Doctor')</th>
                            <th>@lang('Comments')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($patientTreatmentPlans as $patientTreatmentPlan)
                            <tr>
                                <td>
                                    <a href="{{ route('patient-treatment-plans.show', $patientTreatmentPlan->id) }}"
                                        class="text-decoration-underline">

                                        {{ $patientTreatmentPlan->treatment_plan_number }}</a>
                                </td>
                                <td>{{ isset($patientTreatmentPlan->examinvestigation->examination_number) ? $patientTreatmentPlan->examinvestigation->examination_number : '-' }}
                                </td>
                                <td>{{ isset($patientTreatmentPlan->doctor->name) ? $patientTreatmentPlan->doctor->name : '-' }}
                                </td>
                                <td>{{ isset($patientTreatmentPlan->comments) ? $patientTreatmentPlan->comments : '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="tab-prescriptions" role="tabpanel" aria-labelledby="settings-tab">
                <h3>Prescriptions</h3>
                <table class="table table-striped custom-table" id="laravel_datatable">
                    <thead>
                        <tr>
                            <th>@lang('Prescription Number')</th>
                            <th>@lang('Examination Number')</th>
                            <th>@lang('Doctor')</th>
                            <th>@lang('Notes')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($prescriptions as $prescription)
                            <tr>
                                <td>
                                    @if (isset($prescription->examinvestigations->examination_number))
                                        <a href="{{ url('/prescriptions/' . $prescription->id) }}"
                                            class="text-decoration-underline">>
                                            {{ $prescription->examinvestigations->examination_number }}
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ isset($prescription->doctor->name) ? $prescription->doctor->name : '-' }}</td>
                                <td>{{ isset($prescription->note) ? $prescription->note : '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
            <div class="tab-pane fade" id="tab-invoices" role="tabpanel" aria-labelledby="settings-tab">
                <h3>Invoices</h3>
                <table class="table table-striped custom-table" id="laravel_datatable">
                    <thead>
                        <tr>
                            <th>@lang('Invoice Number')</th>
                            <th>@lang('Doctor Name')</th>
                            <th>@lang('Insurance')</th>
                            <th>@lang('Treatment Plan')</th>
                            <th>@lang('Total')</th>
                            <th>@lang('Paid')</th>
                            <th>@lang('Due')</th>
                            <th>@lang('Dated')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoices as $invoice)
                            <tr>
                                <td>
                                    <a href="{{ route('invoices.show', $invoice->id) }}"
                                        class="text-decoration-underline">>
                                        {{ $invoice->invoice_number }}</a>
                                </td>
                                <td>{{ isset($invoice->patienttreatmentplan->doctor->name) ? $invoice->patienttreatmentplan->doctor->name : '-' }}
                                </td>
                                <td>{{ isset($invoice->insurance->name) ? $invoice->insurance->name : '-' }}</td>
                                <td>{{ isset($invoice->patienttreatmentplan->treatment_plan_number) ? $invoice->patienttreatmentplan->treatment_plan_number : '-' }}
                                </td>
                                <td>{{ isset($invoice->grand_total) ? $invoice->grand_total : '-' }}</td>
                                <td>{{ $invoice->paid }}</td>
                                <td>{{ $invoice->due }}</td>
                                <td>{{ $invoice->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    </div>

    <script>
        var getFilesUrl = "{{ route('get-files', $patientDetail->id) }}";
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
                    url: '{{ route("updateInsuranceVerified", $patientDetail->id) }}',
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
@endsection
