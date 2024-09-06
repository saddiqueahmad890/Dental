@extends('layouts.layout')
@section('one_page_js')
<script src="{{ asset('assets/plugins/magnify/dist/jquery.magnify.js') }}"></script>
@endsection

@section('one_page_css')
     <link href="{{ asset('assets/plugins/magnify/dist/jquery.magnify.css') }}" rel="stylesheet">
@endsection
@section('content')


<style>
    h6{
        font-size: 0.8rem !important;
    }
    th{
        font-size:14px;
    }
    td{
        font-size:12px;
    }
</style>


<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('lab-reports.index') }}">@lang('Lab Report')</a></li>
                    <li class="breadcrumb-item active">@lang('Lab Report Info')</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<div class="row">
    <div class="col-md-3">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
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
               
                <h3 class="profile-username text-center">{{ $labReport->user->name }}</h3>
                <p class="text-muted text-center">{{ $labReport->date }}</p>
                <p class="text-center">{{ $labReport->user->phone }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-header bg-info">
                <h3 class="card-title">@lang('Lab Reports Info')</h3>
                <div class="card-tools">
                    @can('lab-report-update')
                        <a href="{{ route('lab-reports.edit', $labReport) }}" class="btn btn-info">@lang('Edit')</a>
                    @endcan
                    <button id="doPrint" class="btn btn-default"><i class="fas fa-print"></i> Print</button>
                </div>
            </div>
            <div class="card-body">
                <div id="print-area" class="row">
                   <div class="row col-12" style="position:relative;">
                                <h4 style="position: absolute; top:30px; left: 41%;">Lab Report</h4>
                            </div>
                    <div class="row ">
                            <div class="col-12">
                                <h4 class="pb-3"><img src="{{ asset('assets/images/logo.png') }}" alt="{{ $ApplicationSetting->item_name }}"
                                    id="custom-opacity-sidebar" class="brand-image">{{ $ApplicationSetting->item_name }}</h4>
                            </div>
                        </div>
                        
                        <div class="row col-12 p-0 m-0">
                            <div class="col-4">
                                <h6 class="size">{{ $ApplicationSetting->company_address }}</h6>
                            </div>
                            <div class="col-8 text-right">
                                <h6 class="size">Patient: {{ $labReport->user->name }}</h6>
                            </div>
                            
                        </div>
                        
                        <div class="row col-12 p-0 m-0">

                            <div class="col-4">
                                <h6 class="size">Email: {{ $ApplicationSetting->company_email }}</h6>
                            </div>
                            <div class="col-8 text-right">
                                <h6 class="size">@lang('MRN no'):
                            {{ $labReport->user->patientDetails->mrn_number ?? ' ' }}</h6>
                            </div>
                            
                        </div>
                        <div class="row col-12 p-0 m-0">

                            <div class="col-4">
                                <h6 class="size">Phone: {{ $ApplicationSetting->contact }}</h6>
                            </div>
                            <div class="col-8 text-right">
                                <h6 class="size">@lang('Lab Report ID') #{{ str_pad($labReport->id, 4, '0', STR_PAD_LEFT) }}</h6>
                            </div>
                            
                        </div>
                        <div class="row col-12 p-0 m-0">

                            <div class="col-4">
                                <h6 class="size">Doctor: {{ $labReport->doctor->name ?? ' ' }}</h6>
                            </div>
                            <div class="col-8 text-right">
                                <h6 class="size">
                                @lang('Report Date'): 
                                {{ date($companySettings->date_format ?? 'Y-m-d', strtotime($labReport->date)) }} <br></h6>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                @if(isset($labReport->photo))
                                    @foreach (json_decode($labReport->photo) as $pic)
                                        @if(pathinfo($pic, PATHINFO_EXTENSION) != "pdf")
                                            <a data-magnify="gallery" data-caption="Report"
                                                href="{{ asset($pic) }}">
                                                <img id="custom-mw-heo" class="rounded" src="{{ asset($pic) }}" alt="">
                                            </a>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                @if(isset($labReport->photo))
                                    @foreach (json_decode($labReport->photo) as $pic)
                                        @if(pathinfo($pic, PATHINFO_EXTENSION) == "pdf")
                                            <a class="my_card" href="{{ asset('storage/'.$pic) }}" target="_blank">
                                                <i class="fas fa-file-pdf fa-7x" class="custom-padding-10"></i>
                                            </a>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="row mt-3">
                <p class="pl-2">
                    This document is created by Username at 27 July 2024, 12:04 AM
                </p>
            </div>
                    </div>
                    <hr class="pb-3">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('footer')
    <script src="{{ asset('assets/js/custom/lab-report/show.js') }}"></script>
@endpush
