@extends('layouts.layout')
@section('one_page_css')
    <link href="{{ asset('assets/css/teethv2.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Patient Dental Analysis (Test)')</h3>
                </div>
                <div class="card-body">
                <form id="patientForm" class="form-material form-horizontal"
                    action="{{ isset($testFile) ? route('test-files.update', $testFile) : route('test-files.store') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (isset($testFile))
                        @method('PUT')
                    @endif
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-">
                            <div class="form-group">
                                <label for="doctor_id">@lang('Doctor')</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-heartbeat"></i></span>
                                    </div>
                                    <select name="doctor_id"
                                        class="form-control select2 @error('doctor_id') is-invalid @enderror" id="doctor_id"
                                        {{ isset($testFile) ? 'disabled' : '' }}>
                                        <option value="" disabled
                                            {{ old('doctor_id', isset($testFile) ? $testFile->doctor_id : null) == null ? 'selected' : '' }}>
                                            {{ isset($testFile) ? '' : 'Select Doctor' }}
                                        </option>
                                        @foreach ($doctors as $doctor)
                                            <option value="{{ $doctor->id }}"
                                                @if (old('doctor_id', isset($testFile) ? $testFile->doctor_id : '') == $doctor->id) selected @endif>
                                                {{ $doctor->name }}</option>
                                        @endforeach
                                    </select>
                                    @if (isset($testFile))
                                        <input type="hidden" name="doctor_id" value="{{ $testFile->doctor_id }}">
                                    @endif
                                    @error('doctor_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                            <div class="form-group">
                                <label for="patient_id">@lang('Patient')</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-heartbeat"></i></span>
                                    </div>
                                    <select name="patient_id"
                                        class="form-control select2 @error('patient_id') is-invalid @enderror"
                                        id="patient_id" {{ isset($testFile) ? 'disabled' : '' }}>
                                        <option value="" disabled
                                            {{ old('patient_id', isset($testFile) ? $testFile->patient_id : null) == null ? 'selected' : '' }}>
                                            {{ isset($testFile) ? '' : 'Select Patient' }}
                                        </option>
                                        @foreach ($patients as $patient)
                                            <option value="{{ $patient->id }}"
                                                @if (old('patient_id', isset($testFile) ? $testFile->patient_id : '') == $patient->id) selected @endif>
                                                {{ $patient->name }}</option>
                                        @endforeach
                                    </select>
                                    @if (isset($testFile))
                                        <input type="hidden" name="patient_id" value="{{ $testFile->patient_id }}">
                                    @endif
                                    @error('patient_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-8">
                            <div class="form-group">
                                <label for="comments">@lang('Comments')</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                                    </div>
                                    <input type="text" id="comments" name="comments"
                                        value="{{ old('comments', isset($testFile) ? $testFile->comments : '') }}"
                                        class="form-control" placeholder="@lang('Comments')">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 col-form-label"></label>
                                <div class="col-md-8">
                                    <input type="submit"
                                        value="{{ isset($testFile) ? __('Update Procedure (Test)') : __('Add Procedure(Test)') }}"
                                        class="btn btn-outline btn-info btn-lg" />
                                    <a href="{{ route('test-files.index') }}"
                                        class="btn btn-outline btn-warning btn-lg">{{ __('Cancel') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                </div>

                <div class="type-of-selection">
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" value="single" id="option-single-selection" checked class="form-check-input" name="optradio">Single Selection
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" value="bulk" id="option-bulk-selection" class="form-check-input" name="optradio">Bulk Selection
                        </label>
                    </div>
                </div>

                <div class="area-bulk-selection">

                </div>

                <div class="Base area-single-selection" style="display: {{ isset($testFile) ? 'block' : 'none' }};">
                        <div class="teeth-container">
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

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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
                        <input type="hidden" id="doctor_id" name="doctor_id">
                        <input type="hidden" id="patient_id" name="patient_id">
                        <input type="hidden" id="teeth_procedures_id" name="teeth_procedures_id" value="{{ old('teeth_procedures_id', isset($testFile) ? $testFile->id : '') }}">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                                <div class="form-group">
                                    <label for="tooth_number">@lang('Tooth') <b
                                            class="ambitious-crimson">*</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-tooth"></i></span>
                                        </div>
                                        <input type="text" id="tooth_number" name="tooth_number"
                                            value="{{ old('tooth_number') }}"
                                            class="form-control @error('tooth_number') is-invalid @enderror"
                                            placeholder="@lang('Name')" readonly>
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table id="teeth_issues" class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="custom-th-width-40">@lang('Tooth Issue')</th>
                                                <th scope="col" class="custom-th-width-60">@lang('Description')</th>
                                                <th scope="col" class="custom-white-space">@lang('Add / Remove')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <select name="tooth_issue[]" class="form-control tooth_issue"
                                                        required>
                                                        <option value="">--@lang('Select')--</option>
                                                        <option value="Carious Class1">Carious Class1</option>
                                                        <option value="Carious Class2">Carious Class2</option>
                                                        <option value="Carious Class3">Carious Class3</option>
                                                        <option value="Mobility Grade1">Mobility Grade1</option>
                                                        <option value="Mobility Grade2">Mobility Grade2</option>
                                                        <option value="Mobility Grade3">Mobility Grade3</option>
                                                        <option value="BDR">BDR</option>
                                                        <option value="Filled">Filled</option>
                                                        <option value="Missing">Missing</option>
                                                        <option value="FPD">FPD</option>
                                                        <option value="RPD">RPD</option>
                                                        <option value="Plaque & Calulus deposits">Plaque & Calulus
                                                            deposits</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <textarea name="description[]" class="form-control" rows="1" placeholder="@lang('Description')"></textarea>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-info m-add"><i
                                                            class="fas fa-plus"></i></button>
                                                    <button type="button" class="btn btn-info m-remove" disabled><i
                                                            class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                        <input type="hidden" name="record_id" id="record_id">
                        <input type="hidden" id="table_name" value="patient">
                        <input type="hidden" id="table" value="teeth_procedures">


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
                                            <br>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>@lang("File Name")</th>
                                                        <th>@lang("Uploaded By")</th>
                                                        <th>@lang("Uploaded At")</th>
                                                        <th>@lang("Actions")</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="teethFileTableBody">
                                                    <!-- Teeth files will be populated here -->
                                                </tbody>
                                            </table>
                                        </div>
                                        @error('teeth_files')
                                            <div class="error ambitious-red">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary" id="openSliderButton">Show Image Slider</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


<!-- Modal for Image Slider -->
<div class="modal fade" id="attachmentsModal" tabindex="-1" role="dialog" aria-labelledby="carouselModalLabel">
    <div class="modal-dialog modal-lg" role="document" style="padding-top: 2%;">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title" style="font-weight:500;">Attached Images</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
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
    <script>
        // Initialize the carousel when the modal is shown
        $('#imageSliderModal').on('shown.bs.modal', function () {
            $('#imageCarousel').carousel({
                interval: 2000 // Optional: Set the interval between slides (in milliseconds)
            });
        });
    </script>

    <script>
        $(document).ready(function() {

            window.escapeFileName = function(fileName) {
            return fileName.replace(/[ .\-()]/g, '_');
            };

            $('.tooth-group').each(function() {
                $(this).click(function() {

                    // Get the teeth number from data attribute
                    var teethNumber = $(this).data('teeth-number');
                    var doctorId = $('#doctor_id').val();
                    var patientId = $('#patient_id').val();
                    var table = $('#table').val();

                    // Set the teeth number in the modal input with specific ID
                    $('#tooth_number').val(teethNumber);
                    $('#exampleModal #doctor_id').val(doctorId);
                    $('#exampleModal #patient_id').val(patientId);
                    $('#exampleModal #record_id').val(patientId);
                    var procedureId=$('#exampleModal #teeth_procedures_id').val();
                    // Show the modal
                    $('#exampleModal').modal('show');
                    $.ajax({
                        url: `/dental/patient-teeth-issues/${procedureId}/${patientId}/${teethNumber}`, // Update with your route
                        type: 'GET',
                        success: function(response) {
                            populateToothIssues(response);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching tooth issues:', error);
                        }

                    });

                });
            });

            function populateToothIssues(toothIssues) {
                // Clear existing rows except the first one
                $('#teeth_issues tbody tr:not(:first)').remove();

                // Populate the first row
                if (toothIssues.length > 0) {
                    var firstIssue = toothIssues[0];
                    $('select[name="tooth_issue[]"]').first().val(firstIssue.tooth_issue).trigger('change');
                    $('textarea[name="description[]"]').first().val(firstIssue.description);
                }

                // Append remaining rows
                for (var i = 1; i < toothIssues.length; i++) {
                    var newRow = $('#teeth_issues tbody tr').first().clone();
                    newRow.find('select[name="tooth_issue[]"]').val(toothIssues[i].tooth_issue).trigger('change');
                    newRow.find('textarea[name="description[]"]').val(toothIssues[i].description);
                    newRow.find('.m-remove').prop('disabled', false);
                    $('#teeth_issues tbody').append(newRow);
                }
            }
        });

        function populateTeethFiles(response) {
        // Clear existing rows in the teeth files table
        $('#teethFileTableBody').html('');

        // Populate the teeth files table
        if (response.files) {
            response.files.forEach(file => {
                var filePath = '/dental/storage/uploads/patient/' + $('#record_id').val() + '/teeth_procedures/' + $('#teeth_procedures_id').val() + '/' + $('#tooth_number').val() + '/' + file.file_name;
                $('#teethFileTableBody').append(
                    `<tr id="file-row-${escapeFileName(file.file_name)}">
                        <td>${file.file_name}</td>
                        <td>${file.uploaded_by}</td>
                        <td>${file.uploaded_at}</td>
                        <td>
                            <span class="btn btn-info">
                                <a style="color:#fff" href="${filePath}" download><i class="fas fa-download"></i></a>
                            </span>
                            <span onclick="confirmDeleteFile('${file.file_name}', 'teeth_files', '${$('#record_id').val()}', 'teethFileTableBody')" class="btn btn-danger">
                                <i class="fas fa-trash-alt"></i>
                            </span>
                        </td>
                    </tr>`
                );
            });

            // If no files, display a message
            if (response.files.length === 0) {
                $('#teethFileTableBody').append('<tr><td colspan="4">@lang("No files found.")</td></tr>');
            }
        }
    }


    window.getFiles = function() {
        var procedureId = $('#exampleModal #teeth_procedures_id').val();
            var teethNumber = $('#tooth_number').val();

            $.ajax({
                url: '/dental/get-teeth-files',
                type: 'GET',
                data: {
                    procedure_id: procedureId,
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
        $('#exampleModal').on('shown.bs.modal', function () {
            getFiles();
        });


        const toothGroups = document.querySelectorAll('.tooth-group');
        toothGroups.forEach(toothGroup => {
            toothGroup.addEventListener('mouseover', () => {
                const paths = toothGroup.querySelectorAll('path');
                paths.forEach(path => {
                    path.style.fill = 'red'; // Change this to your desired hover color
                });
            });

            // Optional: Set the color back to default on mouseout
            toothGroup.addEventListener('mouseout', () => {
                const paths = toothGroup.querySelectorAll('path');
                paths.forEach(path => {
                    path.style.fill = 'white'; // Change this to your default color
                });
            });


        });

        function markSelectedTeeth(toothNumbers) {
    // Ensure toothNumbers is an array
        if (!Array.isArray(toothNumbers)) {
            toothNumbers = [toothNumbers];
        }

        toothNumbers.forEach(function(toothNumber) {
            const toothElement = document.querySelector(`.tooth-group[data-teeth-number="${toothNumber}"]`);
            if (toothElement) {
                toothElement.classList.add('selected');
            }
        });
    }


        document.addEventListener('DOMContentLoaded', function() {
            var procedure_id=$('#exampleModal #teeth_procedures_id').val();

            $.ajax({
                url: `/dental/patient-teeth-issues/${procedure_id}`, // Update with your route
                type: 'GET',
                success: function(response) {
                    console.log(response)
                    markSelectedTeeth(response);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching teeth issues:', error);
                }
            });
        });


        $(document).ready(function() {

            $('input[name="optradio"]').on('click', function() {
                var value = $(this).val();
                if(value == 'single') {
                    $('.area-single-selection').show();
                    $('.area-bulk-selection').hide();
                } else {
                    $('.area-single-selection').hide();
                    $('.area-bulk-selection').show();
                }
                console.log('value : '+value);
                //$('.content').hide();
                //$('#content' + value).show();
            });

            // Initialize select2 for the initial row
            $('.select2').select2();

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
                newRow.find('.select2').select2();
            });

            // Remove button click event handler
            $(document).on('click', '.m-remove', function() {
                $(this).closest('tr').remove();

                // If only one row remains, disable the remove button in that row
                if ($('.m-remove').length === 1) {
                    $('.m-remove').prop('disabled', true);
                }
            });
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
                    // Optionally show a success message or redirect
                },
                error: function(xhr, status, error) {
                    // Handle error response (optional)
                    console.error(xhr.responseText);
                    // Optionally display an error message
                }
            });
        });

        $('#openSliderButton').on('click', function() {
            var procedureId = $('#exampleModal #teeth_procedures_id').val();
            var teethNumber = $('#tooth_number').val();
        fetchImages(procedureId, teethNumber);
    });

    function fetchImages(procedureId, teethNumber) {
        $.ajax({
            url: '/dental/get-teeth-files', // Adjust the route as needed
            type: 'GET',
            data: {
                procedure_id: procedureId,
                tooth_number: teethNumber
            },
            success: function(response) {
                if (response.files && response.files.length > 0) {
                    populateImageSlider(response.files);
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

    function populateImageSlider(files) {
        var indicators = '';
        var innerItems = '';
        var basePath = '/dental/storage/uploads/patient/' + $('#record_id').val() + '/teeth_procedures/' + $('#teeth_procedures_id').val() + '/' + $('#tooth_number').val() + '/';

        files.forEach((file, index) => {
            var isActive = index === 0 ? 'active' : '';
            indicators += `<li data-target="#imageCarousel" data-slide-to="${index}" class="${isActive}"></li>`;
            innerItems += `
                <div class="carousel-item ${isActive}">
                    <img src="${basePath + file.file_name}" alt="Image ${index + 1}" style="width:100%;height:350px"/>
                    <div class="carousel-caption">
                        <p style="display: inline-block; background-color: #0000008a; padding: 0px 10px;">${file.file_name}</p>
                    </div>
                </div>`;
        });

        $('#carouselIndicators').html(indicators);
        $('#carouselInner').html(innerItems);
    }

/////-------------------------------- Array Code for teeth pics ---------------------//
let tooth = document.querySelectorAll('.teeth')
        let selected_tooth_array = [];
        tooth.forEach(function (teeth) {
            teeth.addEventListener('click', function () {
                let teeth_number = this.className.match(/\bteeth-(\d+)\b/)[1];
                let img = this.querySelector('img');
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
                console.log(selected_tooth_array)
            });
        });


    </script>

    @endsection
