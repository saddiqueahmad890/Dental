@extends('layouts.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6 d-flex">
                    <h3 class="mr-2">
                        <a href="{{ route('patient-medical-histories.create') }}" class="btn btn-outline btn-info">+
                            @lang('Add Patient Medical History')
                        </a>
                    </h3>
                    <h3>
                        <a href="{{ route('patient-medical-histories.index') }}" class="btn btn-outline btn-info">
                            <i class="fas fa-eye"></i> @lang('View All')
                        </a>
                    </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('patient-medical-histories.index') }}">@lang('Patient Medical List')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('Edit Patient Medical History')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <input type="hidden" id="record_id" value="{{ $patient->id }}">
                    <input type="hidden" id="table_name" value="patient">
                    <h3 class="card-title">Edit Patient ({{ $patient->name }}) Medical History</h3>
                </div>
                <div class="card-body">
                    <form id="medicalhistoryForm" class=" bg-custom" action="{{ route('patient-medical-histories.update', $patient->id) }}"
                        method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="patient" value="{{ $patient->id }}">
                        <input type="hidden" name="doctor" value="{{ $patientMedicalHistories[0]->doctor_id }}">



                        <div class="row col-12 p-0 m-0">
                            @foreach ($ddMedicalHistories as $item)
                                <div class="col-xl-3 p-3">
                                    <div class="form-group m-0">
                                        <input type="checkbox" id="title_{{ $item->id }}"
                                            name="medical_histories[{{ $item->id }}][checked]"
                                            {{ $patientMedicalHistories->contains('dd_medical_history_id', $item->id) ? 'checked' : '' }}>
                                        <label for="title_{{ $item->id }}">{{ $item->title }}</label>
                                        @if ($patientMedicalHistories->contains('dd_medical_history_id', $item->id))
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend pt-2">
                                                    <span class="input-group-text"><i
                                                            class="fa fa-solid fa-plus-square"></i></span>
                                                </div>
                                                <input type="text" class="form-control mt-2"
                                                    id="details_{{ $item->id }}"
                                                    name="medical_histories[{{ $item->id }}][comments]"
                                                    value="{{ $patientMedicalHistories->where('dd_medical_history_id', $item->id)->first()->comments }}">
                                            </div>
                                            <input type="hidden" value="{{ $item->id }}"
                                                name="medical_histories[{{ $item->id }}][title_id]">
                                        @else
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend pt-2">
                                                    <span class="input-group-text"><i
                                                            class="fa fa-solid fa-plus-square"></i></span>
                                                </div>
                                                <input type="text" class="form-control mt-2"
                                                    id="details_{{ $item->id }}"
                                                    name="medical_histories[{{ $item->id }}][comments]" value="">
                                            </div>
                                            <input type="hidden" value="{{ $item->id }}"
                                                name="medical_histories[{{ $item->id }}][title_id]">
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="row col-12 p-0 m-0">
                            <div class="col-xl-12">
                                <div class="form-group">
                                    <div class="col-md-8">
                                        <input type="submit" value="{{ __('Update') }}"
                                            class="btn btn-outline btn-info btn-lg" />
                                        <a href="{{ route('patient-medical-histories.index') }}"
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
    <div class="card">
        <div class="card-header bg-info">
            <h3 class="card-title">Upload Medical Documents</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="col-md-12">
                        <input id="medical_history" name="medical_history[]" type="file" multiple
                            data-allowed-file-extensions="png jpg jpeg pdf xml txt doc docx mp4"
                            data-max-file-size="2048K" />
                        <p>{{ __('Max Size: 2048kb, Allowed Format: png, jpg, jpeg, pdf, xml, txt, doc, docx, mp4') }}</p>
                        <br>
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
                    @error('other_files')
                        <div class="error ambitious-red">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-2">
        @canany(['userlog-read'])
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">User Logs</h3>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Action</th>
                            <th>Table</th>
                            <th>Column</th>
                            <th>Old Value</th>
                            <th>New Value</th>
                            <th>Timestamp</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $log)
                            <tr>
                                <td>{{ $log->user->name }}</td>
                                <td>{{ $log->action }}</td>
                                <td>{{ $log->table_name }}</td>
                                <td>{{ $log->field_name }}</td>
                                <td>{{ $log->old_value }}</td>
                                <td>{{ $log->new_value }}</td>
                                <td>{{ $log->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endcanany
    </div>
@endsection
<script>
    var getFilesUrl = "{{ route('get-files', $patient->id) }}";
    var uploadFilesUrl = "{{ route('upload-file') }}";
    var deleteFilesUrl = "{{ route('delete-file') }}";
    var baseUrl = '{{ asset('') }}';
</script>
@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Disable all text inputs initially
            $('input[type="text"]').prop('disabled', true);

            // Enable/disable text inputs based on checkbox state
            $('input[type="checkbox"]').change(function() {
                var inputBox = $(this).siblings('input[type="text"]');

                if ($(this).is(':checked')) {
                    inputBox.prop('disabled', false);
                } else {
                    inputBox.prop('disabled', true);
                }
            });
        });
    </script>
@endpush
