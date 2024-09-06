@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('doctor-details.index') }}">@lang('Doctor')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('Doctor Info')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Doctor Info')</h3>
                    @can('doctor-detail-update')
                        <div class="card-tools">
                            <a href="{{ route('doctor-details.edit', $doctorDetail) }}"
                                class="btn btn-info">@lang('Edit')</a>
                        </div>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="bg-custom">
                        <div class="row m-0 p-0">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="name">@lang('Name')</label>
                                    <p>{{ $doctorDetail->user->name ??'-' }}</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="email">@lang('Email')</label>
                                    <p>{{ $doctorDetail->user->email ??'-' }}</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="phone">@lang('Phone')</label>
                                    <p>{{ $doctorDetail->user->phone ??'-' }}</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="address">@lang('Address')</label>
                                    <p>{{ $doctorDetail->user->address ??'-' }}</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="specialist">@lang('Specialist')</label>
                                    <p>{{ $doctorDetail->specialist }}</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="designation">@lang('Designation')</label>
                                    <p>{{ $doctorDetail->designation }}</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="gender">@lang('Gender')</label>
                                    <p>{{ ucfirst($doctorDetail->user->gender ??'-') }}</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="blood_group">@lang('Blood Group')</label>
                                    <p>{{ $doctorDetail->user->ddbloodgroup->name ?? ' ' }}</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="date_of_birth">@lang('Date of Birth')</label>
                                    {{-- <p>{{ $doctorDetail->user->date_of_birth ??'-' }}</p> --}}
                                    <p>{{ $doctorDetail->user->date_of_birth ? \Carbon\Carbon::parse($doctorDetail->user->date_of_birth)->format('d-M-Y') : '-' }}</p>

                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="doctor_biography">@lang('Biography')</label>
                                    <p>{!! $doctorDetail->doctor_biography !!}</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="status">@lang('Status')</label>
                                    <p>
                                        @if ($doctorDetail->user->status == 1)
                                            <span class="badge badge-pill badge-success">@lang('Active')</span>
                                        @else
                                            <span class="badge badge-pill badge-danger">@lang('Inactive')</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="commission">@lang('Commission')</label>
                                    <p>
                                        {!! $doctorDetail->commission  !!}%
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="card">




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
                </ul>

                <!-- Tab content -->
                <div class="tab-content" id="myTabContent"
                    style="    border-left: 1px solid #ccc;    border: 1px solid #ccc;    margin-top: -1px;    padding: 20px;">
                    <div class="tab-pane fade show active" id="tab-appointments" role="tabpanel"
                        aria-labelledby="home-tab">
                        <h3>Appointments</h3>
                        <table class="table table-striped" id="laravel_datatable">
                            <thead>
                                <tr>
                                    <th>@lang('Appointment Number')</th>
                                    <th>@lang('Patient')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Problem')</th>
                                    <th>@lang('Start Time')</th>
                                    <th>@lang('End Time')</th>
                                    <th>@lang('Dated')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($patientAppointments as $patientAppointment)
                                    <tr>
                                        <td>
                                            <a href="{{ route('patient-appointments.show', $patientAppointment->id) }}"  class="text-decoration-underline">
                                                {{ $patientAppointment->appointment_number }}
                                            </a>
                                        </td>

                                        <td>{{ isset($patientAppointment->user->name) ? $patientAppointment->user->name : '-' }}
                                        </td>
                                        <td>{{ isset($patientAppointment->appointmentstatus->name) ? $patientAppointment->appointmentstatus->name : '-' }}
                                        </td>
                                        <td>{{ $patientAppointment->problem }}</td>
                                        <td>{{ $patientAppointment->start_time }}</td>
                                        <td>{{ $patientAppointment->end_time }}</td>
                                        <td>{{ $patientAppointment->appointment_date ? \Carbon\Carbon::parse($patientAppointment->appointment_date)->format('d-M-Y') : '-'}}</td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="tab-exam-investigations" role="tabpanel"
                        aria-labelledby="profile-tab">
                        <h3>Exam Investigations</h3>
                        <table class="table table-striped" id="laravel_datatable">
                            <thead>
                                <tr>
                                    <th>@lang('Examination Number')</th>
                                    <th>@lang('Appointment Number')</th>
                                    <th>@lang('Patient')</th>
                                    <th>@lang('Comments')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($examInvestigations as $examInvestigation)
                                    <tr>
                                        <td>
                                            <a href="{{ route('exam-investigations.show', $examInvestigation->id) }}"  class="text-decoration-underline">
                                                {{ $examInvestigation->examination_number }}</a>
                                        </td>

                                        <td>{{ isset($examInvestigation->PatientAppointment->appointment_number) ? $examInvestigation->PatientAppointment->appointment_number : '-' }}
                                        </td>
                                        <td>{{ isset($examInvestigation->patient->name) ? $examInvestigation->patient->name : '-' }}
                                        </td>
                                        <td>{{ $examInvestigation->comments }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    <div class="tab-pane fade" id="tab-treatment-plans" role="tabpanel" aria-labelledby="messages-tab">
                        <h3>Treatment Plans</h3>
                        <table class="table table-striped" id="laravel_datatable">
                            <thead>
                                <tr>
                                    <th>@lang('Treatment Plan Number')</th>
                                    <th>@lang('Examination Number')</th>
                                    <th>@lang('Patient')</th>
                                    <th>@lang('Comments')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($patientTreatmentPlans as $patientTreatmentPlan)
                                    <tr>
                                        <td>
                                            <a
                                                href="{{ route('patient-treatment-plans.show', $patientTreatmentPlan->id) }}"  class="text-decoration-underline">
                                                {{ $patientTreatmentPlan->treatment_plan_number }}</a>
                                        </td>
                                        <td>{{ isset($patientTreatmentPlan->examinvestigation->examination_number) ? $patientTreatmentPlan->examinvestigation->examination_number : '-' }}
                                        </td>
                                        <td>{{ isset($patientTreatmentPlan->patient->name) ? $patientTreatmentPlan->patient->name : '-' }}
                                        </td>
                                        <td>{{ $patientTreatmentPlan->comments }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="tab-prescriptions" role="tabpanel" aria-labelledby="settings-tab">
                        <h3>Prescriptions</h3>
                        <table class="table table-striped" id="laravel_datatable">
                            <thead>
                                <tr>
                                    <th>@lang('Prescription Number')</th>
                                    <th>@lang('Examination Number')</th>
                                    <th>@lang('Patient')</th>
                                    <th>@lang('Notes')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($prescriptions as $prescription)
                                    <tr>
                                        <td>
                                            <a href="{{ route('prescriptions.show', $prescription->id) }}" class="text-decoration-underline">

                                                {{ $prescription->prs_number }}</a>
                                        </td>
                                        <td>{{ isset($prescription->examinvestigations->examination_number) ? $prescription->examinvestigations->examination_number : '-' }}
                                        </td>
                                        <td>{{ isset($prescription->user->name) ? $prescription->user->name : '-' }}</td>
                                        <td>{{ $prescription->note }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection
