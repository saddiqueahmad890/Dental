@extends('layouts.layout')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                  <div class="col-sm-6 d-flex">
                    <h3 class="mr-2">
                        <a href="{{ route('lab-reports.create') }}" class="btn btn-outline btn-info">+ @lang('Lab Report')</a>
                        <span class="pull-right"></span>
                    </h3>
                    <h3>
                        <a href="{{ route('lab-reports.index') }}" class="btn btn-outline btn-info"><i class="fas fa-eye"></i> @lang('View All')</a>
                    </h3>
            </div>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('lab-reports.index') }}">@lang('Lab Report')</a></li>
                    <li class="breadcrumb-item active">@lang('Edit Lab Report')</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<input type="hidden" id="record_id" value="{{ $labReport->id }}">
<input type="hidden" id="table_name" value="labreport">
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info">
                <h3 class="card-title">Edit Lab Report ({{ $labReport->user->name }})</h3>
            </div>
            <div class="card-body">
                <form id="labReportEditFrom" class="form-material form-horizontal bg-custom" action="{{ route('lab-reports.update', $labReport) }}" method="POST" enctype="multipart/form-data" data-parsley-validate>
                    @csrf
                    @method('PUT')
                    <div class="row col-12 m-0 p-0">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date">@lang('Date')</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-calendar-check"></i></span>
                                    </div>
                                    <input type="text" name="date" id="date" class="form-control flatpickr" value="{{ $labReport->date }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="patient_id">@lang('Select Patient') </label>
                                <div class="form-group input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user-injured"></i></span>
                                    </div>
                                    <select name="patient_id" id="patient_id" class="form-control select2 custom-width-100" disabled>
                                        @foreach($patientInfo as $key => $value)
                                            <option value="{{ $value->id }}" @if($value->id == $labReport->patient_id) selected @endif>{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row col-12 m-0 p-0">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="report">@lang('Report') <b class="ambitious-crimson">*</b></label>
                                <div id="input_report" class="description-min-height">
                                    <!-- The div with id 'input_report' appears to be for display purposes; ensure it's used as intended. -->
                                </div>
                                <textarea
                                    id="report"
                                    name="report"
                                    class="form-control custom-display-none"
                                    data-parsley-required="false"
                                    data-parsley-required-message="@lang('The report field is required.')"
                                    data-parsley-trigger="change"
                                >{{ $labReport->report }}</textarea>
                                @error('report')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="row col-12 m-0 p-0">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 col-form-label"></label>
                                <div class="col-md-8">
                                    <input type="submit" value="{{ __('Update') }}" class="btn btn-outline btn-info btn-lg"/>
                                    <a href="{{ route('lab-reports.index') }}" class="btn btn-outline btn-warning btn-lg">{{ __('Cancel') }}</a>
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
        <h3 class="card-title">Upload Lab Report Documents</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="col-md-12">
                    <input id="lab_reports" name="lab_reports[]" type="file" multiple
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
                        <tbody id="labReportsTableBody" class="fileTableBody"></tbody>
                        <!-- Other files will be loaded here via AJAX -->
                        </tbody>
                    </table>
                </div>
                @error('lab_files')
                    <div class="error ambitious-red">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </div>
</div>
<script>
    var getFilesUrl = "{{ route('get-files', $labReport->id) }}";
    var uploadFilesUrl = "{{ route('upload-file') }}";
    var deleteFilesUrl = "{{ route('delete-file') }}";
    var baseUrl = '{{ asset('') }}';
</script>

@endsection

@push('footer')
    <script src="{{ asset('assets/js/custom/lab-report/edit.js') }}"></script>
@endpush
