@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <div class="col-sm-6 d-flex">
                        <input type="hidden" id="record_id" value="{{ $patientDetail->id }}">
                        <input type="hidden" id="table_name" value="patient">
                        <div id="buttonContainer">
                            <!-- Medical History Buttons -->
                            <div id="medicalHistoryButtons">
                                <h3 class="mr-2">
                                    @if ($patientMedicalHistories->isEmpty())
                                        <!-- If no data, show the + Add button -->
                                        <a href="{{ route('patient-medical-histories.create.from-patient', ['userid' => $patientDetail->id]) }}"
                                            class="btn btn-outline btn-info">+
                                            @lang('Add Patient Medical History')
                                        </a>
                                    @endif
                                </h3>
                            </div>

                            <!-- Drug History Buttons -->
                            <div id="drugHistoryButtons">
                                <h3 class="mr-2">
                                    @if ($patientDrugHistories->isEmpty())
                                        <!-- If no data, show the + Add button -->
                                        <a href="{{ route('patient-drug-histories.create.from-patient', ['userid' => $patientDetail->id]) }}"
                                            class="btn btn-outline btn-info">
                                            + @lang('Add Patient Drug History')
                                        </a>
                                    @endif
                                </h3>
                            </div>

                            <!-- Social History Buttons -->
                            <div id="socialHistoryButtons">
                                <h3 class="mr-2">
                                    @if ($patientSocialHistories->isEmpty())
                                        <!-- If no data, show the + Add button -->
                                        <a href="{{ route('patient-social-histories.create.from-patient', ['userid' => $patientDetail->id]) }}"
                                            class="btn btn-outline btn-info">+
                                            @lang('Add Patient Social History')
                                        </a>
                                    @endif
                                </h3>
                            </div>

                            <!-- Dental History Buttons -->
                            <div id="dentalHistoryButtons">
                                <h3 class="mr-2">
                                    @if ($patientDentalHistories->isEmpty())
                                        <!-- If no data, show the + Add button -->
                                        <a href="{{ route('patient-dental-histories.create.from-patient', ['userid' => $patientDetail->id]) }}"
                                            class="btn btn-outline btn-info">+
                                            @lang('Add Patient Dental History')
                                        </a>
                                    @endif
                                </h3>

                            </div>

                        </div>
                    </div>
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
                <div class="card-header bg-info d-flex align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="profile-pic2">
                            <img class="profile-user-img img-fluid img-circle"
                                src="{{ asset('storage/' . $profilePicture) }}" alt="" />
                        </div>
                        <h3 class="card-title ml-2 mt-2">@lang('Patient history') - {{ $patientDetail->name }}</h3>
                    </div>
                    <button id="generatePrint" class="btn btn-default ml-auto"><i class="fas fa-print"></i> Print</button>
                </div>


                <div class="card-body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                aria-controls="home" aria-selected="true">@lang('Medical History')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                                aria-controls="profile" aria-selected="false">@lang('Drug History')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="messages-tab" data-toggle="tab" href="#messages" role="tab"
                                aria-controls="messages" aria-selected="false">@lang('Social History')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="settings-tab" data-toggle="tab" href="#settings" role="tab"
                                aria-controls="settings" aria-selected="false">@lang('Dental History')</a>
                        </li>
                    </ul>

                    <!-- Tab content -->
                    <div class="tab-content" id="myTabContent">
                        <!-- Medical History Tab Content -->
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            @if ($patientMedicalHistories->isNotEmpty())
                                <div class="row">
                                    <div class="col-md-9">
                                        <h3>@lang('Medical History of') {{ $patientDetail->name }}</h3>
                                    </div>
                                    <div class="col-md-3 text-right">
                                        <a href="{{ route('patient-medical-histories.edit', ['patient_medical_history' => $patientMedicalHistories->first()->id]) }}"
                                            class="btn btn-info mt-2">@lang('Edit Medical History')</a>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    @foreach ($patientMedicalHistories as $item)
                                        <div class="col-xl-3 p-3">
                                            <div class="form-group m-0">
                                                <label>{{ $item->ddMedicalHistory->title }}</label>
                                                <p>{{ $item->comments }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div id="medicalDocumentsCard" class="card" style="display: none;">
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
                            @else
                                <p>@lang('No medical history found.')</p>
                            @endif
                        </div>

                        <!-- Drug History Tab Content -->

                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            @if ($patientDrugHistories->isNotEmpty())
                                <div class="row">
                                    <div class="col-md-10">
                                        <h3>@lang('Drug History of') {{ $patientDetail->name }}</h3>
                                    </div>
                                    <div class="col-md-2 text-right">
                                        <a href="{{ route('patient-drug-histories.edit', ['patient_drug_history' => $patientDrugHistories->first()->id]) }}"
                                            class="btn btn-info mt-2">@lang('Edit Drug History')</a>
                                    </div>
                                </div>
                                <hr>
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
                                <div id="drugHistoryCard" class="card">
                                    <div class="card-header bg-info">
                                        <h3 class="card-title">Drug Documents</h3>
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
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <p>@lang('No drug history found.')</p>
                            @endif
                        </div>

                        <!-- Social History Tab Content -->
                        <div class="tab-pane fade" id="messages" role="tabpanel" aria-labelledby="messages-tab">
                            @if ($patientSocialHistories->isNotEmpty())
                                <div class="row">
                                    <div class="col-md-10">
                                        <h3>@lang('Social History of') {{ $patientDetail->name }}</h3>
                                    </div>
                                    <div class="col-md-2 text-right">
                                        <a href="{{ route('patient-social-histories.edit', ['patient_social_history' => $patientSocialHistories->first()->id]) }}"
                                            class="btn btn-info mt-2">@lang('Edit Social History')</a>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    @foreach ($patientSocialHistories as $item)
                                        <div class="col-xl-3 p-3">
                                            <div class="form-group m-0">
                                                <label>{{ $item->ddSocialHistory->title }}</label>
                                                <p>{{ $item->comments }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div id="socialHistoryCard" class="card">
                                    <div class="card-header bg-info">
                                        <h3 class="card-title">Social Documents</h3>
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
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <p>@lang('No social history found.')</p>
                            @endif
                        </div>

                        <!-- Dental History Tab Content -->
                        <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                            @if ($patientDentalHistories->isNotEmpty())
                                <div class="row">
                                    <div class="col-md-10">
                                        <h3>@lang('Dental History of') {{ $patientDetail->name }}</h3>
                                    </div>
                                    <div class="col-md-2 text-right">
                                        <a href="{{ route('patient-dental-histories.edit', ['patient_dental_history' => $patientDentalHistories->first()->id]) }}"
                                            class="btn btn-info mt-2">@lang('Edit Dental History')</a>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    @foreach ($patientDentalHistories as $item)
                                        <div class="col-xl-3 p-3">
                                            <div class="form-group m-0">
                                                <label>{{ $item->ddDentalHistory->title }}</label>
                                                <p>{{ $item->comments }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div id="dentalHistoryCard" class="card">
                                    <div class="card-header bg-info">
                                        <h3 class="card-title">Dental Documents</h3>
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
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <p>@lang('No dental history found.')</p>
                            @endif
                        </div>

                    </div>
                </div>

                <div id="print-section" style="display:none">
                    <div class="row">
                        <div class="col-12">
                            <div class="invoice p-3 mb-3">
                                <div class="row">
                                    <h4 style="position: absolute; top: 45px; left: 39%;">{{ $patientDetail->name }}</h4>
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


                                </div>

                                <div class="row col-12 m-0 p-0">

                                    <div class="col-4">
                                        <h6 class="size">Email: {{ $ApplicationSetting->company_email }}</h6>
                                    </div>
                                    <div class="col-8 text-right">
                                        <h6 class="size">Patient:
                                            {{ $patientDetail->patientDetails->user->name ?? ' ' }}</h6>
                                    </div>

                                </div>
                                <div class="row col-12 m-0 p-0">

                                    <div class="col-4">
                                        <h6 class="size">Phone: {{ $ApplicationSetting->contact }}</h6>
                                    </div>
                                    <div class="col-8 text-right">
                                        <h6 class="size">Phone: {{ $patientDetail->phone ?? '-' }}</h6>
                                    </div>

                                </div>
                                <div class="row col-12 m-0 p-0">
                                    <div class="col-4">
                                        <h6 class="size"></h6>
                                    </div>
                                    <div class="col-8 text-right">
                                        <h6 class="size">Date:
                                            {{ date($companySettings->date_format ?? 'Y-m-d', strtotime($patientDetail->patientDetail_date)) }}
                                        </h6>
                                    </div>

                                </div>
                                <div class="row col-12 m-0 p-0">

                                    <div class="col-4">
                                        <h6 class="size"></h6>
                                    </div>
                                    <div class="col-8 text-right">
                                        <h6 class="size">MRN no:
                                            {{ $patientDetail->patientDetails->mrn_number ?? ' ' }}</h6>
                                    </div>

                                </div>



                                @if ($patientDentalHistories->isNotEmpty())
                                    <div class="row">
                                        <div class="col-md-10">
                                            <h3>@lang('Dental History of') {{ $patientDetail->name }}</h3>
                                        </div>
                                    </div>
                                    <hr>
                                    <table class="table table-bordered custom-table">
                                        <tbody>
                                            @foreach ($patientDentalHistories->chunk(4) as $chunk)
                                                <tr>
                                                    @foreach ($chunk as $item)
                                                        <td style="border: 1px solid #17a2b8; width: 25%;">
                                                            <span
                                                                style="font-weight:bold;">{{ $item->ddDentalHistory->title }}</span>
                                                            <br>
                                                            <span>{{ $item->comments }}</span>
                                                        </td>
                                                    @endforeach
                                                    @for ($i = 0; $i < 4 - $chunk->count(); $i++)
                                                        <td style="border: 1px solid #17a2b8; width: 25%;"></td>
                                                    @endfor
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif

                                <hr>
                                @if ($patientSocialHistories->isNotEmpty())
                                    <div class="row">
                                        <div class="col-md-10">
                                            <h3>@lang('Social History of') {{ $patientDetail->name }}</h3>
                                        </div>
                                    </div>
                                    <hr>
                                    <table class="table table-bordered custom-table">
                                        <tbody>
                                            @foreach ($patientSocialHistories->chunk(4) as $chunk)
                                                <tr>
                                                    @foreach ($chunk as $item)
                                                        <td style="border: 1px solid #17a2b8; width: 25%;">
                                                            <span
                                                                style="font-weight:bold;">{{ $item->ddSocialHistory->title }}</span>
                                                            <br>
                                                            <span>{{ $item->comments }}</span>
                                                        </td>
                                                    @endforeach
                                                    @for ($i = 0; $i < 4 - $chunk->count(); $i++)
                                                        <td style="border: 1px solid #17a2b8; width: 25%;"></td>
                                                    @endfor
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                                <hr>
                                @if ($patientDrugHistories->isNotEmpty())
                                    <div class="row">
                                        <div class="col-md-10">
                                            <h3>@lang('Drug History of') {{ $patientDetail->name }}</h3>
                                        </div>
                                    </div>
                                    <hr>
                                    <table class="table table-bordered custom-table">
                                        <tbody>
                                            @foreach ($patientDrugHistories->chunk(4) as $chunk)
                                                <tr>
                                                    @foreach ($chunk as $item)
                                                        <td style="border: 1px solid #17a2b8; width: 25%;">
                                                            <span
                                                                style="font-weight:bold;">{{ $item->ddDrugHistory->title }}</span>
                                                            <br>
                                                            <span>{{ $item->comments }}</span>
                                                        </td>
                                                    @endforeach
                                                    @for ($i = 0; $i < 4 - $chunk->count(); $i++)
                                                        <td style="border: 1px solid #17a2b8; width: 25%;"></td>
                                                    @endfor
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                                <hr>
                                @if ($patientMedicalHistories->isNotEmpty())
                                    <div class="row">
                                        <div class="col-md-10">
                                            <h3>@lang('Medical History of') {{ $patientDetail->name }}</h3>
                                        </div>
                                    </div>
                                    <hr>
                                    <table class="table table-bordered custom-table">
                                        <tbody>
                                            @foreach ($patientMedicalHistories->chunk(4) as $chunk)
                                                <tr>
                                                    @foreach ($chunk as $item)
                                                        <td style="border: 1px solid #17a2b8; width: 25%;">
                                                            <span
                                                                style="font-weight:bold;">{{ $item->ddMedicalHistory->title }}</span>
                                                            <br>
                                                            <span>{{ $item->comments }}</span>
                                                        </td>
                                                    @endforeach
                                                    @for ($i = 0; $i < 4 - $chunk->count(); $i++)
                                                        <td style="border: 1px solid #17a2b8; width: 25%;"></td>
                                                    @endfor
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                                <hr>


                                <div class="row">
                                    <p class="pl-2">
                                        This document is created by
                                        {{ $patientDetail->patientDetails->creator->name ?? '-' }} at
                                        {{ $patientDetail->patientDetails->created_at ?? '-' }} and printed by
                                        {{ Auth::user()->name }} at {{ now()->format('Y-m-d H:i:s') }}
                                    </p>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>


                <!-- JavaScript Section -->
                <script>
                    var getFilesUrl = "{{ route('get-files', $patientDetail->id) }}";
                    var uploadFilesUrl = "{{ route('upload-file') }}";
                    var deleteFilesUrl = "{{ route('delete-file') }}";
                    var baseUrl = '{{ asset('') }}';
                </script>
                <script>
                    $(document).ready(function() {

                        setTimeout(function() {
                            const tableBody = $('#medicalHistoryTableBody');
                            const card = $('#medicalDocumentsCard');

                            if (tableBody.find('tr').length > 0) {
                                console.log("This is Console", tableBody);
                                card.show(); // Show the card if there are rows in the table body
                            } else {
                                card.hide(); // Hide the card if there are no rows
                                console.log("This is Else", tableBody);
                            }
                            const drugHistoryTableBody = $('#drugHistoryTableBody');
                            const drugHistoryCard = $('#drugHistoryCard');

                            if (drugHistoryTableBody.find('tr').length > 0) {
                                drugHistoryCard.show();
                            } else {
                                drugHistoryCard.hide();
                            }

                            // Check and show/hide Social History section
                            const socialHistoryTableBody = $('#socialHistoryTableBody');
                            const socialHistoryCard = $('#socialHistoryCard');

                            if (socialHistoryTableBody.find('tr').length > 0) {
                                socialHistoryCard.show();
                            } else {
                                socialHistoryCard.hide();
                            }

                            // Check and show/hide Dental History section
                            const dentalHistoryTableBody = $('#dentalHistoryTableBody');
                            const dentalHistoryCard = $('#dentalHistoryCard');

                            if (dentalHistoryTableBody.find('tr').length > 0) {
                                dentalHistoryCard.show();
                            } else {
                                dentalHistoryCard.hide();
                            }
                        }, 600);


                        $(document).on('click', '#generatePrint', function() {
                            $('#print-section').show();
                            var printContent = $('#print-section').html();
                            $('body').html(printContent);
                            window.print();
                            location.reload();
                        });


                        $('#myTab a').on('click', function(e) {
                            e.preventDefault();
                            $(this).tab('show');

                            var activeTab = $(this).attr('id');
                            switch (activeTab) {
                                case 'home-tab':
                                    $('#medicalHistoryButtons').show();
                                    $('#drugHistoryButtons, #socialHistoryButtons, #dentalHistoryButtons').hide();
                                    break;
                                case 'profile-tab':
                                    $('#drugHistoryButtons').show();
                                    $('#medicalHistoryButtons, #socialHistoryButtons, #dentalHistoryButtons').hide();
                                    break;
                                case 'messages-tab':
                                    $('#socialHistoryButtons').show();
                                    $('#medicalHistoryButtons, #drugHistoryButtons, #dentalHistoryButtons').hide();
                                    break;
                                case 'settings-tab':
                                    $('#dentalHistoryButtons').show();
                                    $('#medicalHistoryButtons, #drugHistoryButtons, #socialHistoryButtons').hide();
                                    break;
                            }
                        });

                        // Trigger click on the active tab to show the correct buttons initially
                        $('#myTab a.active').trigger('click');
                    });
                </script>
            @endsection
