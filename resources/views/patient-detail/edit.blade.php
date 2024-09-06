@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6 d-flex">
                    <h3 class="mr-2"><a href="{{ route('patient-details.create') }}" class="btn btn-outline btn-info">+
                            @lang('Add Patient')</a>
                        <span class="pull-right"></span>
                    </h3>
                    <h3><a href="{{ route('patient-details.index') }}" class="btn btn-outline btn-info">
                            <i class="fas fa-eye"></i> @lang('View All')</a>
                        <span class="pull-right"></span>
                    </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('patient-details.index') }}">@lang('Patient')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('Edit Patient')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <input type="hidden" id="record_id" value="{{ $patientDetail->id }}">
    <input type="hidden" id="table_name" value="patient">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">Edit Patient ({{ $patientDetail->name }}) </h3>
                </div>
                <div class="card-body">
                    <form id="departmentForm" class="form-material form-horizontal bg-custom"
                        action="{{ route('patient-details.update', $patientDetail) }}" method="POST"
                        enctype="multipart/form-data" data-parsley-validate>
                        @csrf
                        @method('PUT')
                        <meta name="csrf-token" content="{{ csrf_token() }}">

                        <div class="row col-12">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3">
                                <div class="form-group">
                                    <label for="name">@lang('Name') <b class="ambitious-crimson">*</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                        </div>
                                        <input type="text" id="name" name="name"
                                            value="{{ old('name', $patientDetail->name) }}"
                                            class="form-control @error('name') is-invalid @enderror"
                                            placeholder="@lang('Name')" required data-parsley-required="true"
                                            data-parsley-pattern="^[a-zA-Z\s]+$"
                                            data-parsley-required-message="@lang("Please enter patient's name")">
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3">
                                <div class="form-group">
                                    <label for="phone">@lang('Phone')<b class="ambitious-crimson">*</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        </div>
                                        <input type="text" id="phone" name="phone"
                                            value="{{ old('phone', $patientDetail->phone) }}"
                                            class="form-control @error('phone') is-invalid @enderror"
                                            placeholder="@lang('Phone')" required
                                            data-parsley-required-message="Please enter phone no">
                                        @error('phone')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3">
                                <div class="form-group">
                                    <label for="email">@lang('Email') <b class="ambitious-crimson">*</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-at"></i></span>
                                        </div>
                                        <input type="email" id="email" name="email"
                                            value="{{ old('email', $patientDetail->email) }}"
                                            class="form-control @error('email') is-invalid @enderror"
                                            placeholder="@lang('Email')" required
                                            data-parsley-required-message="Please enter valid email">
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3">
                                <div class="form-group">
                                    <label for="gender">@lang('Gender')</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                        </div>
                                        <select name="gender"
                                            class="form-control select2 @error('gender') is-invalid @enderror"
                                            id="gender">
                                            <option value="" disabled
                                                @if (old('gender', $patientDetail->gender) == null) selected @endif>
                                                @lang('Select Gender')
                                            </option>
                                            <option value="male" @if (old('gender', $patientDetail->gender) == 'male') selected @endif>
                                                @lang('Male')
                                            </option>
                                            <option value="female" @if (old('gender', $patientDetail->gender) == 'female') selected @endif>
                                                @lang('Female')
                                            </option>
                                        </select>
                                        @error('gender')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row col-12">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3">
                                <div class="form-group">
                                    <label for="blood_group">@lang('Blood Group')</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-heartbeat"></i></span>
                                        </div>
                                        <select name="blood_group"
                                            class="form-control @error('blood_group') is-invalid @enderror"
                                            id="blood_group">
                                            <option value="" disabled
                                                @if (old('blood_group', $patientDetail->blood_group) == null) selected @endif>
                                                Select Blood Group
                                            </option>
                                            @foreach ($bloodGroups as $bloodGroup)
                                                <option value="{{ $bloodGroup->id }}"
                                                    @if (old('blood_group', $patientDetail->blood_group) == $bloodGroup->id) selected @endif>
                                                    {{ $bloodGroup->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('blood_group')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>


                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3">
                                <div class="form-group">
                                    <label for="date_of_birth">@lang('Date of Birth')</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-check"></i></span>
                                        </div>
                                        <input type="text" name="date_of_birth" id="date_of_birth"
                                            class="form-control flatpickr @error('date_of_birth') is-invalid @enderror"
                                            placeholder="@lang('Date of Birth')"
                                            value="{{ old('date_of_birth', $patientDetail->date_of_birth) }}">
                                        @error('date_of_birth')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3">
                                <div class="form-group">
                                    <label for="marital_status">@lang('Marital Status') <b
                                            class="ambitious-crimson">*</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-heart"></i></span>
                                        </div>
                                        <select name="marital_status"
                                            class="form-control select2 @error('marital_status') is-invalid @enderror"
                                            id="marital_status">
                                            <option value="" disabled
                                                @if (old('marital_status', $patientDetail->patientDetails->marital_status ?? ' ') == null) selected @endif>
                                                @lang('Select Marital Status')
                                            </option>
                                            @foreach ($maritalStatuses as $maritalStatus)
                                                <option value="{{ $maritalStatus->id }}"
                                                    @if (old('marital_status', $patientDetail->patientDetails->marital_status ?? ' ') == $maritalStatus->id) selected @endif>
                                                    {{ $maritalStatus->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('marital_status')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3">
                                <div class="form-group">
                                    <label for="cnic">@lang(' CNIC / Passport')</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                        </div>
                                        <input type="text" id="cnic" name="cnic"
                                            value="{{ old('cnic', $patientDetail->patientDetails->cnic ?? ' ') }}"
                                            class="form-control" placeholder="@lang('CNIC')">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row col-12">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3">
                                <div class="form-group">
                                    <label for="credit_balance">@lang('Credit_balance')</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                        </div>
                                        <input type="number" name="credit_balance" id="credit_balance"
                                            class="form-control @error('credit_balance') is-invalid @enderror"
                                            value="{{ old('credit_balance', $patientDetail->patientDetails->credit_balance ?? ' ') }}"
                                            placeholder="@lang('Credit_balance')" />
                                        @error('credit_balance')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>



                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3">
                                <div class="form-group">
                                    <label for="insurance_provider_id">@lang('Insurance Provider')</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-building"></i></span>
                                        </div>
                                        <select
                                            class="form-control select2 ambitious-form-loading @error('insurance_provider_id') is-invalid @enderror"
                                            name="insurance_provider_id" id="insurance_provider_id">
                                            <option value="" @if (is_null(old('insurance_provider_id', $patientDetail->patientDetails->insurance_provider_id ?? null))) selected @endif>
                                                @lang('Select Provider')
                                            </option>

                                            @foreach ($insuranceProviders as $insuranceProvider)
                                                <option value="{{ $insuranceProvider->id }}"
                                                    @if (old('insurance_provider_id', optional($patientDetail->patientDetails)->insurance_provider_id) ==
                                                            $insuranceProvider->id) selected @endif>
                                                    {{ $insuranceProvider->name }}
                                                </option>
                                            @endforeach

                                        </select>
                                        @error('insurance_provider_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3">

                                <div class="form-group">
                                    <label for="area">@lang('Area')</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i
                                                    class="fa fa-solid fa-map-marker"></i></span>
                                        </div>
                                        <input type="text" name="area" id="area"
                                            class="form-control @error('area') is-invalid @enderror"
                                            value="{{ old('area', $patientDetail->patientDetails->area ?? ' ') }}"
                                            placeholder="@lang('Area')" />
                                        @error('area')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3">
                                <div class="form-group">
                                    <label for="city">@lang('City')</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i
                                                    class="fa fa-solid fa-map-marker"></i></span>
                                        </div>
                                        <input type="text" name="city" id="city"
                                            class="form-control @error('city') is-invalid @enderror"
                                            value="{{ old('city', $patientDetail->patientDetails->city ?? ' ') }}"
                                            placeholder="@lang('City')" />
                                        @error('city')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row col-12">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3">
                                <div class="form-group">
                                    <label for="address">@lang('Address')</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i
                                                    class="fa fa-solid fa-map-marker"></i></span>
                                        </div>
                                        <input type="text" name="address" id="address"
                                            class="form-control @error('address') is-invalid @enderror" rows="1"
                                            value="{{ old('address', $patientDetail->address) }}"
                                            placeholder="@lang('address')" />
                                        @error('address')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3">
                                <div class="form-group">
                                    <label for="status">@lang('Status') <b class="ambitious-crimson">*</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-bell"></i></span>
                                        </div>
                                        <select
                                            class="form-control select2 ambitious-form-loading @error('status') is-invalid @enderror"
                                            required name="status" id="status">
                                            <option value="" disabled
                                                @if (old('status', $patientDetail->status) == null) selected @endif>
                                                @lang('Select Status')
                                            </option>
                                            <option value="1" @if (old('status', $patientDetail->status) == '1') selected @endif>
                                                @lang('Active')
                                            </option>
                                            <option value="0" @if (old('status', $patientDetail->status) == '0') selected @endif>
                                                @lang('Inactive')
                                            </option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="password" name="password" value="12345678" required>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3">
                                <div class="form-group">
                                    <label for="other_details">@lang('Other Details')</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-file"></i></span>
                                        </div>
                                        <textarea name="other_details" id="other_details" class="form-control @error('other_details') is-invalid @enderror"
                                            rows="1" placeholder="@lang('other_details')">{{ old('other_details', $patientDetail->patientDetails->other_details ?? ' ') }}</textarea>
                                        @error('address')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3">
                                <div class="form-group">
                                    <label for="enquirysource">@lang('Where did you hear about us?')</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-heartbeat"></i></span>
                                        </div>
                                        <select name="enquirysource"
                                            class="form-control select2 @error('enquiry') is-invalid @enderror"
                                            id="enquirysource">
                                            <option value="" disabled> Select Source </option>
                                            @foreach ($enquirysource as $enquiry)
                                                <option value="{{ $enquiry->id }}"
                                                    @if (old('enquirysource', $patientDetail->patientDetails->enquirysource ?? ' ') == $enquiry->id) selected @endif>
                                                    {{ $enquiry->source_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('enquirysource')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row col-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 col-form-label"></label>
                                    <div class="col-md-8">
                                        <input type="submit" value="{{ __('Update') }}"
                                            class="btn btn-outline btn-info btn-lg" />
                                        <a href="{{ route('patient-details.index') }}"
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
            <h3 class="card-title">Upload Profile Picture</h3>
        </div>
        <div class="card-body bg-custom">
            <div class="row col-12 p-0 m-0">
                <div class="col-12">
                    <div class="col-md-12">
                        <input id="profile_picture" name="profile_picture" type="file"
                            data-allowed-file-extensions="png jpg jpeg" data-max-file-size="2048K" />
                        <p>{{ __('Max Size: 2048kb, Allowed Format: png, jpg, jpeg') }}</p>
                        <br>
                        <table class="table table-bordered custom-table">
                            <thead>
                                <tr>
                                    <th>@lang('Profile Picture')</th>
                                    <th>@lang('Uploaded By')</th>
                                    <th>@lang('Upload Date')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody id="profilePictureTableBody" class="fileTableBody"></tbody>

                            </tbody>
                        </table>
                    </div>
                    @error('profile_picture')
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
            <h3 class="card-title">Upload CNIC</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="col-md-12">
                        <input id="cnic_file" name="cnic_file[]" type="file" multiple
                            data-allowed-file-extensions="png jpg jpeg pdf" data-max-file-size="2048K" />
                        <p>{{ __('Max Size: 2048kb, Allowed Format: png, jpg, jpeg, pdf') }}</p>
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


    <div class="card"
        style="{{ isset($patientDetail->patientDetails) && $patientDetail->patientDetails->insurance_provider_id !== null ? 'display: block;' : 'display: none;' }}">
        <div class="card-header bg-info">
            <h3 class="card-title">Upload Insurance Documents</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="col-md-12">
                        <input id="insurance_card" name="insurance_card[]" type="file" multiple
                            data-allowed-file-extensions="png jpg jpeg pdf" data-max-file-size="2048K" />
                        <p>{{ __('Max Size: 2048kb, Allowed Format: png, jpg, jpeg, pdf') }}</p>
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
                            <tbody id="insuranceCardTableBody" class="fileTableBody"></tbody>
                            <!-- Insurance files will be loaded here via AJAX -->
                            </tbody>
                        </table>
                        <div class="form-check" style="{{ $insuranceFiles > 0 ? 'display: block;' : 'display: none;' }}">
                            <input class="form-check-input" style="position: static; margin-top:1px;" type="checkbox"
                                value="yes" id="insuranceVerifiedCheckbox"
                                {{ isset($patientDetail->patientDetails->insurance_verified) === 'yes' ? 'checked' : '' }}>
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
            <h3 class="card-title">Upload Other Documents</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="col-md-12">
                        <input id="other_files" name="other_files[]" type="file" multiple
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

    @php
        $statusMapping = [
            1 => 'Single',
            2 => 'Married',
            3 => 'Divorced',
            // Add other statuses if needed
        ];
    @endphp
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
                                <td>
                                    @if ($log->field_name === 'marital_status')
                                        {{ $statusMapping[$log->old_value] ?? $log->old_value }}
                                    @else
                                        {{ $log->old_value }}
                                    @endif
                                </td>
                                <td>
                                    @if ($log->field_name === 'marital_status')
                                        {{ $statusMapping[$log->new_value] ?? $log->new_value }}
                                    @else
                                        {{ $log->new_value }}
                                    @endif
                                </td>
                                <td>{{ $log->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endcanany
    </div>


    <script>
        var getFilesUrl = "{{ route('get-files', $patientDetail->id) }}";
        var uploadFilesUrl = "{{ route('upload-file') }}";
        var deleteFilesUrl = "{{ route('delete-file') }}";
        var baseUrl = '{{ asset('') }}';
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const insuranceVerifiedCheckbox = document.getElementById('insuranceVerifiedCheckbox');

            insuranceVerifiedCheckbox.addEventListener('change', function() {
                const insurance_verified = this.checked ? 'yes' : 'no';
                $.ajax({
                    url: '{{ route('updateInsuranceVerified', $patientDetail->id) }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        insurance_verified: insurance_verified
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Insurance status updated successfully.');
                        } else {
                            alert('Failed to update insurance status.');
                        }
                    },
                    error: function(xhr) {
                        alert('Error occurred while updating insurance status: ' + xhr
                            .responseJSON.message);
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
