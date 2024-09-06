<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .size{
            font-size: 0.8rem;
        }
        .custom-th,.custom-label{
            font-size:14px !important;
        }
        .custom-td,.custom-p{
            font-size:12px;
        }
        @media print {

            /* Hide elements that should not be printed */
            .no-print,
            #doPrint {
                display: none;
            }

            /* Ensure the card and content styles are maintained */
            .card {
                border: 1px solid #dee2e6;
                border-radius: 0.25rem;
                padding: 1rem;
            }

            .card-header bg-info,
            .card-body {
                padding: 0;
            }

            /* Make sure the layout fits well on the page */
            .container-fluid,
            .row,
            .col-md-3,
            .col-md-4,
            .col-md-12 {
                width: 100%;
                margin: 0;
                padding: 0;
            }

            .form-group {
                margin-bottom: 1rem;
            }

            .profile-user-img {
                width: 50px;
                height: 50px;
                object-fit: cover;
            }

            /* Adjust font sizes for printing */
            body {
                font-size: 12pt;
            }

            .btn {
                display: none;
            }
        }
    </style>
</head>
@extends('layouts.layout')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3>
                        <a href="{{ route('patient-appointments.index') }}" class="btn btn-outline btn-info"><i
                                class="fas fa-eye"></i> @lang('View All')</a>

                    </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('patient-appointments.index') }}">@lang('Patient Appointment')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('Patient Appointment Info')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card ">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Patient Appointment Info')</h3>
                </div>
                <div class="card-body " id="print-area">
                    <div class="border p-3">
                        <div class="row col-12">
                        <div class="row">
                                <h4 style="position: absolute; top: 35px; left: 39%;">Appointment Info</h4>
                            </div>
                            <div class="col-12">
                                <h4 class="pb-3"><img src="{{ asset('assets/images/logo.png') }}" alt="{{ $ApplicationSetting->item_name }}"
                                    id="custom-opacity-sidebar" class="brand-image">{{ $ApplicationSetting->item_name }}</h4>
                            </div>
                        </div>

                        <div class="row col-12 p-0 m-0">
                            <div class="col-12">

                        <div class="row col-12 p-0 m-0">
                            <div class="col-4">
                                <h6 class="size">{{ $ApplicationSetting->company_address }}</h6>
                            </div>
                            <div class="col-8 text-right">
                                <h6 class="size">Patient: {{ $patientAppointment->user->name ?? '-' }}</h6>
                            </div>

                        </div>

                        <div class="row col-12 p-0 m-0">

                            <div class="col-4">
                                <h6 class="size">Email: {{ $ApplicationSetting->company_email }}</h6>
                            </div>
                            <div class="col-8 text-right">
                                <h6 class="size">Gender: {{ $patientAppointment->user->gender ?? '-' }}</h6>
                            </div>

                        </div>
                        <div class="row col-12 p-0 m-0">

                            <div class="col-4">
                                <h6 class="size">Phone: {{ $ApplicationSetting->contact }}</h6>
                            </div>
                            <div class="col-8 text-right">
                                <h6 class="size">Phone: {{ $patientAppointment->user->phone ??'-' }}</h6>
                            </div>

                        </div>
                        <hr class="pb-3">



                        <div class="row col-12 p-0 m-0">
                            <div class="col-sm-3">
                                <div class="d-flex align-items-center">
                                    <div class="mr-3">
                                        @if ($profilePicture)
                                            <img class="profile-user-img img-fluid img-circle"
                                                src="{{ asset('storage/' . $profilePicture) }}" alt="Profile Picture"
                                                style="width: 50px; height: 50px; object-fit: cover;" />
                                        @else
                                            <img class="profile-user-img img-fluid rounded-circle"
                                                src="{{ asset('assets/images/profile/male.png') }}"
                                                alt="Default Profile Picture"
                                                style="width: 50px; height: 50px; object-fit: cover;" />
                                        @endif
                                    </div>
                                    <div>
                                        <label class="custom-label"  class="custom-label"  for="user_id">@lang('Patient Name')</label>
                                        <p class="custom-p">{{ $patientAppointment->user->name ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="custom-label"  class="custom-label"  for="appointment_number">@lang('MRN Number')</label>
                                    <p class="custom-p">{{ $patientAppointment->user->patientdetails->mrn_number ?? ' ' }}</p>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="custom-label"  class="custom-label"  for="appointment_number">@lang('Contact Number')</label>
                                    <p class="custom-p">{{ $patientAppointment->user->phone ?? ' ' }}</p>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="d-flex align-items-center">
                                    <div class="mr-3">
                                        @if (isset($patientAppointment->doctor->photo_url))
                                        <img class="profile-user-img img-fluid img-circle"
                                        src="{{ $patientAppointment->doctor->photo_url }}" alt=""
                                        style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;" />
                                        @else
                                            <img class="profile-user-img img-fluid rounded-circle"
                                                src="{{ asset('assets/images/profile/male.png') }}"
                                                alt="Default Profile Picture"
                                                style="width: 50px; height: 50px; object-fit: cover;" />
                                        @endif
                                    </div>
                                    <div>
                                        <label class="custom-label"  class="custom-label"  for="doctor_id">@lang('Doctor Name')</label>
                                        <p class="custom-p">{{ $patientAppointment->doctor->name ?? ' ' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="pb-3">

                        <div class="row col-12 p-0 m-0">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="custom-label"  class="custom-label"  for="appointment_number">@lang('Appointment Number')</label>
                                    <p class="custom-p">{{ $patientAppointment->appointment_number ?? ' ' }}</p>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="custom-label"  class="custom-label"  for="appointment_date">@lang('Appointment Date')</label>
                                    <p class="custom-p">{{ \Carbon\Carbon::parse($patientAppointment->appointment_date)->format('d F Y') }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="custom-label"  class="custom-label"  for="appointment_slot">@lang('Appointment Time')</label>
                                    <p class="custom-p">{{ \Carbon\Carbon::parse($patientAppointment->start_time)->format('h:i A') . ' - ' . \Carbon\Carbon::parse($patientAppointment->end_time)->format('h:i A') }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group" ">
                                    <label  class="custom-label"  class="custom-label"  for="status">@lang('Status')</label>
                                    <p class="custom-p">{{ $patientAppointment->appointmentstatus->name ?? ' ' }}</p>
                                </div>
                            </div>
                        </div>


                        <div class="row col-12 p-0 m-0">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="custom-label"  class="custom-label"  for="problem">@lang('Problem/Description')</label>
                                    <p class="custom-p">{{ $patientAppointment->problem }}</p>
                                </div>
                            </div>


                        </div>

                        <div class="row col-12 p-0 m-0 mt-4">


                            <div class="col-2 no-print">
                                <div class="form-group">
                                    <label class="custom-label"  for="status">@lang('Status')</label>
                                    @php
                                        $currentDate = \Carbon\Carbon::now()->format('Y-m-d');
                                        $currentStatus = $statuses->firstWhere(
                                            'id',
                                            $patientAppointment->appointment_status_id,
                                        );

                                        $isDisabled =
                                            isset($currentStatus) &&
                                            ($currentStatus->name == 'Cancelled' ||
                                                $currentStatus->name == 'Processed' ||
                                                $patientAppointment->appointment_date < $currentDate);
                                    @endphp


                                    <select id="status" name="status" class="form-control"
                                        @if ($isDisabled) disabled @endif>
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status->id }}"
                                                @if (old('status', $patientAppointment->appointment_status_id) == $status->id) selected @endif>
                                                {{ $status->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-8"></div>
                            <div class="col-md-2">
                                <div class="btn pt-4">
                                    <button id="doPrint" class="btn btn-default"><i class="fas fa-print"></i>
                                        Print</button>
                                </div>
                            </div>
                        </div>
                        <div class="row col-12 m-0 p-0">
                            <p class="pl-1 mt-2">
                                This document is created by {{ $patientAppointment->creator->name ?? "-" }} at {{ $patientAppointment->created_at ?? "-" }} and printed by {{ Auth::user()->name }} at {{ now()->format('Y-m-d H:i:s') }}


                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-2 no-print">
        @canany(['userlog-read'])
        <div class="card">
            <div class="card-header bg-info">
                <h3 class="card-title">User Logs</h3>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="custom-th">User</th>
                        <th class="custom-th">Action</th>
                        <th class="custom-th">Table</th>
                        <th class="custom-th">Column</th>
                        <th class="custom-th">Old Value</th>
                        <th class="custom-th">New Value</th>
                        <th class="custom-th">Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($logs as $log)
                        <tr>
                            <td class="custom-td">{{ $log->user->name }}</td>
                            <td class="custom-td">{{ $log->action }}</td>
                            <td class="custom-td">{{ $log->table_name }}</td>
                            <td class="custom-td">{{ $log->field_name }}</td>
                            <td class="custom-td">{{ $log->old_value }}</td>
                            <td class="custom-td">{{ $log->new_value }}</td>
                            <td class="custom-td">{{ $log->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endcanany
    </div>


    <script>
        $(document).ready(function() {
            // Save the initial value for future reference
            var previousStatus = $('#status').val();
            console.log("previous status is",previousStatus);
            $('#status').on('change', function() {
                var statusId = $(this).val();
                var appointmentId = {{ $patientAppointment->id }};
                console.log("Currently selected status is",statusId);
                if (statusId == '1' || statusId == '2') {
                    console.log("First",statusId);
                    updateStatus(statusId, appointmentId);
                } else if (statusId == '8' || statusId == '3') {
                    console.log("Second",statusId);

                    var confirmationMessage = statusId == '8' ?
                        'Are you sure you want to Cancel the appointment?' :
                        'Are you sure you want to Process the appointment?';

                    var userConfirmed = confirm(confirmationMessage);
                    if (userConfirmed) {
                        // Disabling the status select
                        $(this).prop('disabled', true);
                        localStorage.setItem('alertShown', 'true');

                        // Proceed with updating the status
                        updateStatus(statusId, appointmentId);
                    } else {
                        // Reset the status select to its previous value if the user cancels
                        $(this).val(previousStatus);
                    }
                }

                // Save the current value for future reference
                previousStatus = statusId;
            });

            function updateStatus(statusId, appointmentId) {
                $.ajax({
                    url: '{{ route('change.status') }}', // Update this route to point to your actual route for updating the status
                    type: 'POST', // Changed to POST for updating data
                    data: {
                        statusId: statusId,
                        appointmentId: appointmentId,
                        _token: '{{ csrf_token() }}' // Include CSRF token for security
                    },
                    success: function(response) {
                        alert("Status updated successfully");
                        // Optionally reload the page if needed
                        // window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }
        });
    </script>




    @include('layouts.delete_modal')
@endsection
