@extends('layouts.layout')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('patient-case-studies.index') }}">@lang('Patient')</a></li>
                    <li class="breadcrumb-item active">@lang('Patient Case Study')</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<div class="row">
    <div class="col-md-3">
        <div class="card card-primary card-outline p-0 m-0" style="height:97%;">
            <div class="card-body box-profile pt-2">
                <div class="bg-custom p-2">
                <div class="text-center">
                    <img class="profile-user-img profile-user-img-custom img-fluid img-circle" src="{{ $patientCaseStudy->user->photo_url }}" alt="" />
                </div>
                    <h3 class="profile-username text-center mt-5">{{ $patientCaseStudy->user->name ??'-' }}</h3>
                    <p class="text-muted text-center">{{ $patientCaseStudy->user->email ??'-' }}</p>
                    <p class="text-center">{{ $patientCaseStudy->user->phone ??'-' }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-header bg-info">
                <h3 class="card-title">@lang('Patient Case Study Info')</h3>
                @can('patient-case-studies-update')
                    <div class="card-tools">
                        <a href="{{ route('patient-case-studies.edit', $patientCaseStudy) }}" class="btn btn-info">@lang('Edit')</a>
                    </div>
                @endcan
            </div>
            <div class="card-body">
                <div class="bg-custom">
                    <div class="row col-12 m-0 p-0">
                        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
                            <div class="form-group">
                                <label for="name">@lang('Food Allergy')</label>
                                <p>{{ $patientCaseStudy->food_allergy }}</p>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
                            <div class="form-group">
                                <label for="email">@lang('Heart Disease')</label>
                                <p>{{ $patientCaseStudy->heart_disease }}</p>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
                            <div class="form-group">
                                <label for="phone">@lang('High Blood Pressure')</label>
                                <p>{{ $patientCaseStudy->high_blood_pressure }}</p>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
                            <div class="form-group">
                                <label for="name">@lang('Diabetic')</label>
                                <p>{{ $patientCaseStudy->diabetic }}</p>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
                            <div class="form-group">
                                <label for="email">@lang('Surgery')</label>
                                <p>{{ $patientCaseStudy->surgery }}</p>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
                            <div class="form-group">
                                <label for="phone">@lang('Accident')</label>
                                <p>{{ $patientCaseStudy->accident }}</p>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
                            <div class="form-group">
                                <label for="name">@lang('Others')</label>
                                <p>{{ $patientCaseStudy->others }}</p>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
                            <div class="form-group">
                                <label for="email">@lang('Family Medical History')</label>
                                <p>{{ $patientCaseStudy->family_medical_history }}</p>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
                            <div class="form-group">
                                <label for="phone">@lang('Current Medication')</label>
                                <p>{{ $patientCaseStudy->current_medication }}</p>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
                            <div class="form-group">
                                <label for="name">@lang('Pregnancy')</label>
                                <p>{{ $patientCaseStudy->pregnancy }}</p>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
                            <div class="form-group">
                                <label for="email">@lang('Breast Feeding')</label>
                                <p>{{ $patientCaseStudy->breastfeeding }}</p>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
                            <div class="form-group">
                                <label for="phone">@lang('Health Insurance')</label>
                                <p>{{ $patientCaseStudy->health_insurance }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if ($patientCaseStudy->file)
    @php
        $extension = pathinfo(asset($patientCaseStudy->file), PATHINFO_EXTENSION);
    @endphp
    @if ($extension == 'pdf')
    <div class="text-center">
        <embed src="{{ asset($patientCaseStudy->file)}}" width="100%" height="600px" />
    </div>
    @else
    <div class="text-center">
        <img class="img-fluid img-thumbnail" src="{{ asset($patientCaseStudy->file) }}" width="1280" height="600px" alt="" />
    </div>
    @endif
@endif

@endsection
