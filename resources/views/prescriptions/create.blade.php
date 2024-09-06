@extends('layouts.layout')

@section('content')
    <section class="content-header">
        <meta name="base-url" content="{{ url('/') }}">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <a href="{{ route('prescriptions.index') }}" class="btn btn-outline btn-info"><i class="fas fa-eye"></i>
                        @lang('View All')</a>

                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('prescriptions.index') }}">@lang('Prescription')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('Add Prescription')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Add Prescription')</h3>
                </div>
                <div class="card-body">
                    <form class="form-material form-horizontal bg-custom" action="{{ route('prescriptions.store') }}" method="POST"
                    enctype="multipart/form-data" data-parsley-validate>
                    @csrf
                    <div class="row col-12 p-0 m-0">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="user_id">@lang('Select Patient') <b class="ambitious-crimson">*</b></label>
                                <div class="form-group input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user-injured"></i></span>
                                    </div>
                                    <select name="user_id"
                                        class="form-control select2 @error('user_id') is-invalid @enderror"
                                        id="user_id" required data-parsley-required-message="@lang('Please select a patient')">
                                        <option value="">--@lang('Select')--</option>
                                        @foreach ($patients as $patient)
                                            <option value="{{ $patient->id }}"
                                                {{ old('user_id') == $patient->id ? 'selected' : '' }}>
                                                {{ $patient->name }} - {{ $patient->patientDetails->mrn_number ?? ' ' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label for="examination_id">@lang('Select Examination')</label>
                            <div class="form-group input-group mb-3 mt-1">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-plus-square"></i></span>
                                </div>
                                <select class="form-control @error('examination_id') is-invalid @enderror"
                                    id="examination_id" name="examination_id" >
                                    <option value="">@lang('Select Examination')</option>
                                </select>
                            </div>
                            @error('examination_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('Prescription Date') <b class="ambitious-crimson">*</b></label>
                                <div class="form-group input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                    </div>
                                    <input type="text" name="prescription_date" id="prescription_date"
                                        class="form-control flatpickr @error('prescription_date') is-invalid @enderror"
                                        placeholder="@lang('Prescription Date')"
                                        value="{{ old('prescription_date', date('Y-m-d')) }}" required
                                        data-parsley-required-message="@lang('Please select a prescription date')">
                                </div>
                                @error('prescription_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row col-12 p-0 m-0">
                        <div class="col-md-3 pt-2">
                            <button type="button" class="btn btn-info mb-3" data-toggle="collapse" href="#history"
                                style="width: max-content;">
                                <i class="fas fa-file-alt"></i> @lang('Patient Histories')</button>
                        </div>
                        <br><br>
                    </div>

                    <div id="history" class="collapse">
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home"
                                        role="tab" aria-controls="home" aria-selected="true">Medical History</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile"
                                        role="tab" aria-controls="profile" aria-selected="false">Drug History</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="messages-tab" data-toggle="tab" href="#messages"
                                        role="tab" aria-controls="messages" aria-selected="false">Social History</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="settings-tab" data-toggle="tab" href="#settings"
                                        role="tab" aria-controls="settings" aria-selected="false">Dental History</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent"
                                style="border-left: 1px solid #ccc; border: 1px solid #ccc; margin-top: -1px; padding: 20px;">
                                <div class="tab-pane fade show active" id="home" role="tabpanel"
                                    aria-labelledby="home-tab">
                                    <div class="col-md-10">
                                        <h3>@lang('Medical History of') {{ $patientName }} </h3>
                                    </div>
                                    <hr>
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
                                </div>
                                <div class="tab-pane fade" id="profile" role="tabpanel"
                                    aria-labelledby="profile-tab">
                                    <div class="col-md-10">
                                        <h3>@lang('Drug History of') {{ $patientName ?? '-' }}</h3>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        @foreach ($patientDrugHistories as $item)
                                            <div class="col-xl-3 p-3">
                                                <div class="form-group m-0">
                                                    <label>{{ $item->ddDrugHistory->title ?? ' ' }}</label>
                                                    <p>{{ $item->comments }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="messages" role="tabpanel"
                                    aria-labelledby="messages-tab">
                                    <div class="col-md-10">
                                        <h3>@lang('Social History of') {{ $patientName }} </h3>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        @foreach ($patientSocialHistories as $item)
                                            <div class="col-xl-3 p-3">
                                                <div class="form-group m-0">
                                                    <label>{{ $item->ddSocialHistory->title ?? ' ' }}</label>
                                                    <p>{{ $item->comments }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="settings" role="tabpanel"
                                    aria-labelledby="settings-tab">
                                    <div class="col-md-10">
                                        <h3>@lang('Dental History of') {{ $patientName ?? '-' }}</h3>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        @foreach ($patientDentalHistories as $item)
                                            <div class="col-xl-3 p-3">
                                                <div class="form-group m-0">
                                                    <label>{{ $item->ddDentalHistory->title ?? ' ' }}</label>
                                                    <p>{{ $item->comments }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table id="t1" class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">@lang('Medicine Type')</th>
                                                <th scope="col">@lang('Medicine Name')</th>
                                                <th scope="col">@lang('Description')</th>
                                                {{-- <th scope="col">@lang('Instruction')</th> --}}
                                                <th scope="col">@lang('Days')</th>
                                                <th scope="col" class="custom-white-space">@lang('Add / Remove')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (old('medicine_name'))
                                                @foreach (old('medicine_name') as $key => $value)
                                                    <tr>
                                                        <td>
                                                            <input type="text" name="medicine_type[]"
                                                                class="form-control"
                                                                value="{{ old('medicine_type')[$key] }}"
                                                                placeholder="@lang('Medicine Type')">

                                                        </td>
                                                        <td>
                                                            <input type="text" name="medicine_name[]"
                                                                class="form-control"
                                                                value="{{ old('medicine_name')[$key] }}"
                                                                placeholder="@lang('Medicine Name')">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="medicine_description[]"
                                                                class="form-control"
                                                                value="{{ old('medicine_description')[$key] }}"
                                                                placeholder="@lang('Description')">
                                                        </td>
                                                        {{-- <td>
                                                            <input type="text" name="instruction[]"
                                                                class="form-control"
                                                                value="{{ old('instruction')[$key] }}"
                                                                placeholder="@lang('Instructions')">
                                                        </td> --}}
                                                        <td>
                                                            <input type="text" name="day[]" class="form-control"
                                                                value="{{ old('day')[$key] }}"
                                                                placeholder="@lang('Days')">
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-info m-add"><i
                                                                    class="fas fa-plus"></i></button>
                                                            <button type="button" class="btn btn-info m-remove"><i
                                                                    class="fas fa-trash"></i></button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                        <tbody id="medicine">
                                            <tr>
                                                <td>
                                                    <select name="medicine_type[]"
                                                        class="form-control  @error('medicine_type') is-invalid @enderror"
                                                        id="medicine_type">
                                                        <option value="" disabled selected>Select Medicine Type
                                                        </option>
                                                        @foreach ($medicineTypes as $medicineType)
                                                            <option value="{{ $medicineType->id }}">
                                                                {{ $medicineType->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="medicine_name[]"
                                                        class="form-control  @error('medicine_name') is-invalid @enderror"
                                                        id="medicine_name">
                                                        <option value="" disabled selected>Select Medicine</option>

                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="medicine_description[]" class="form-control" id="medicine_description" readonly>
                                                </td>
                                                {{-- <td>
                                                    <input type="text" name="instruction[]" class="form-control"
                                                        value="" placeholder="@lang('Instructions')">
                                                </td> --}}
                                                <td>
                                                    <input type="text" name="day[]" class="form-control"
                                                        value="" placeholder="@lang('Days')">
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-info m-add"><i
                                                            class="fas fa-plus"></i></button>
                                                    <button type="button" class="btn btn-info m-remove"><i
                                                            class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="bg-info">
                                            <tr>
                                                <th scope="col">@lang('Diagnosis')</th>
                                                <th scope="col">@lang('Instruction')</th>
                                                <th scope="col" class="custom-white-space custom-width-120">
                                                    @lang('Add / Remove')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (old('diagnosis'))
                                                @foreach (old('diagnosis') as $key => $value)
                                                    <tr>
                                                        <td>
                                                            <input type="text" name="diagnosis[]"
                                                                class="form-control "
                                                                value="{{ old('diagnosis')[$key] }}"
                                                                placeholder="@lang('Diagnosis')">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="diagnosis_instruction[]"
                                                                class="form-control "
                                                                value="{{ old('diagnosis_instruction')[$key] }}"
                                                                placeholder="@lang('Instruction')">
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-info d-add"><i
                                                                    class="fas fa-plus"></i></button>
                                                            <button type="button" class="btn btn-info d-remove"><i
                                                                    class="fas fa-trash"></i></button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                        <tbody id="diagnosis">
                                            <tr>
                                                <td>
                                                    <select name="diagnosis[]"
                                                        class="form-control @error('diagnosis') is-invalid @enderror"
                                                        id="diagnosis">
                                                        <option value="" disabled selected>Select Diagnosis
                                                        </option>
                                                        @foreach ($ddDiagnosises as $ddDiagnosis)
                                                            <option value="{{ $ddDiagnosis->id }}">
                                                                {{ $ddDiagnosis->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="diagnosis_instruction[]"
                                                        class="form-control" value=""
                                                        placeholder="@lang('Instruction')">
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-info d-add"><i
                                                            class="fas fa-plus"></i></button>
                                                    <button type="button" class="btn btn-info d-remove"><i
                                                            class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row col-12 p-0 m-0">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="note">@lang('Note')</label>
                                    <div class="input-group mb-3">
                                        <textarea name="note" id="note" class="form-control @error('note') is-invalid @enderror" rows="4"
                                            placeholder="@lang('Note')">{{ old('note') }}</textarea>
                                        @error('note')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 col-form-label"></label>
                                    <div class="col-md-8">
                                        <input type="submit" value="{{ __('Submit') }}"
                                            class="btn btn-outline btn-info btn-lg" />
                                        <a href="{{ route('prescriptions.index') }}"
                                            class="btn btn-outline btn-warning btn-lg">{{ __('Cancel') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function setupTeethProceduresDropdown() {
            $(document).ready(function() {
                function getUrlParameter(name) {
                    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
                    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
                    var results = regex.exec(location.search);
                    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
                }
            });
        }



        setupTeethProceduresDropdown();

        $(document).ready(function() {
            function getQueryParam(param) {
                var urlParams = new URLSearchParams(window.location.search);
                return urlParams.get(param);
            }

    // Get user_id from the URL
    var storedUserId = getQueryParam('user_id');
            if (storedUserId) {
                $('#user_id').val(storedUserId);
                fetchProcedures(storedUserId);
            }

            // Fetch procedures on page load
            function fetchProcedures(userId) {
                $.ajax({
                    url: '{{ route('fetchexamination') }}',
                    type: 'GET',
                    data: {
                        user_id: userId
                    },
                    success: function(data) {
                        var examInvestigations = data.examInvestigations;
                        var options = '<option value="" disabled selected>Select Examination</option>';
                        $.each(examInvestigations, function(index, examInvestigation) {
                            options += '<option value="' + examInvestigation.id + '">' +
                                examInvestigation
                                .examination_number + '</option>';
                        });
                        $('#examination_id').html(options);

                        // Store procedures in local storage
                        localStorage.setItem('procedures', JSON.stringify(examInvestigations));
                    },
                    error: function(xhr, status, error) {
                        alert('Failed to fetch Teeth Procedures! Please try again.');
                    }
                });
            }

            // Event listener for user ID change
            $('#user_id').on('change', function() {
                var userId = $(this).val();

                // Store the user ID in local storage
                localStorage.setItem('user_id', userId);

                fetchProcedures(userId);
            });

            // Function to populate procedures from local storage
            function populateProcedures() {
                var storedexamInvestigations = JSON.parse(localStorage.getItem('examInvestigations'));
                if (storedexamInvestigations) {
                    var options = '<option value="" disabled selected>Select Examination</option>';
                    $.each(storedexamInvestigations, function(index, storedexamInvestigation) {
                        options += '<option value="' + storedexamInvestigation.id + '">' +
                            storedexamInvestigation.examination_number + '</option>';
                    });
                    $('#examination_id').html(options);
                }
            }

            // Call the function to populate procedures if they exist in local storage
            populateProcedures();
        });
    </script>




@endsection
@push('footer')
    <script src="{{ asset('assets/js/custom/prescription.js') }}"></script>
@endpush
