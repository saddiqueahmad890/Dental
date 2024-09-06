@extends('layouts.layout')
<style>
    .err-custom-txt-area ~ .parsley-errors-list{
        top: 110px;
    }
</style>
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-8">
                  <div class="col-sm-6 d-flex">
                    <h3 class="mr-2"><a href="{{ route('lab-report-templates.create') }}" class="btn btn-outline btn-info">+ @lang('Lab Report Template')</a>
                        <span class="pull-right"></span>
                    </h3>
                    <h3>
                        <a href="{{ route('lab-report-templates.index') }}" class="btn btn-outline btn-info"><i class="fas fa-eye"></i> @lang('View All')</a>

                    </h3>
            </div>
            </div>
            <div class="col-sm-4">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('lab-report-templates.index') }}">@lang('Lab Report Template')</a></li>
                    <li class="breadcrumb-item active">@lang('Edit Lab Report Template')</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info">
                <h3 class="card-title">Edit Lab Report Template ({{ $labReportTemplate->name }})</h3>
            </div>
            <div class="card-body">
                <form id="patientForm" class="form-material form-horizontal bg-custom" action="{{ route('lab-report-templates.update', $labReportTemplate) }}" method="POST" enctype="multipart/form-data" data-parsley-validate>
                    @csrf
                    @method('PUT')

                    <div class="row col-12 m-0 p-2">
                        <div class="form-group">
                            <label for="name">@lang('Template Name') <b class="ambitious-crimson">*</b></label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                </div>
                                <input type="text" id="name" name="name" value="{{ old('name', $labReportTemplate->name) }}" class="form-control @error('name') is-invalid @enderror" placeholder="@lang('Template Name')" required data-parsley-required-message="@lang('Please enter template name')" data-parsley-trigger="change">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row col-12 m-0 p-2">
                        <div class="form-group">
                            <label for="template">@lang('Report Body') <b class="ambitious-crimson">*</b></label>
                            <br>
                            <span class="hide_in_read">
                                <a id="textarea_patient_name" class="btn btn-default btn-sm">#PATIENT_NAME#</a>
                                <a id="textarea_patient_gender" class="btn btn-default btn-sm">#PATIENT_GENDER#</a>
                                <a id="textarea_patient_blood" class="btn btn-default btn-sm">#PATIENT_BLOOD#</a>
                                <a id="textarea_hospital_name" class="btn btn-default btn-sm">#HOSPITAL_NAME#</a>
                                <a id="textarea_doctor_name" class="btn btn-default btn-sm">#DOCTOR_NAME#</a>
                                <a id="textarea_report_date" class="btn btn-default btn-sm">#REPORT_DATE#</a>
                            </span>
                            <div class="input-group mb-3">
                                <textarea name="template" id="template" class="form-control err-custom-txt-area @error('template') is-invalid @enderror" rows="4" placeholder="@lang('Report Body')" required data-parsley-required-message="@lang('Please enter report body')" data-parsley-trigger="change">{{ old('template', $labReportTemplate->template) }}</textarea>
                                @error('template')
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
                                    <a href="{{ route('lab-report-templates.index') }}" class="btn btn-outline btn-warning btn-lg">{{ __('Cancel') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('footer')
    <script src="{{ asset('assets/js/custom/lab-report-template.js') }}"></script>
@endpush
