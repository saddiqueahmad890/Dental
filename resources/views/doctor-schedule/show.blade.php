@extends('layouts.layout')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('doctor-schedules.index') }}">@lang('Doctor Schedule')</a></li>
                    <li class="breadcrumb-item active">@lang('Add Doctor Schedule')</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info">
                <h3 class="card-title">@lang('Add Doctor Schedule')</h3>
                @can('doctor-schedule-update')
                    <div class="card-tools">
                        <a href="{{ route('doctor-schedules.edit', $doctorSchedule) }}" class="btn btn-info">@lang('Edit')</a>
                    </div>
                @endcan
            </div>
            <div class="card-body">
                <div class="bg-custom">
                    <div class="row col-12 m-0 p-0">
                        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-6">
                            <div class="form-group">
                                <label for="user_id">@lang('Doctor Name')</label>
                                <p>{{ $doctorSchedule->user->name ??'-' }}</p>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-6">
                            <div class="form-group">
                                <label for="weekday">@lang('Weekday')</label>
                                <p>{{ $doctorSchedule->weekday }}</p>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-6">
                            <div class="form-group">
                                <label for="status">@lang('Status')</label>
                                <p>
                                    @if($doctorSchedule->status == '1')
                                        <span class="badge badge-pill badge-success">@lang('Active')</span>
                                    @else
                                        <span class="badge badge-pill badge-danger">@lang('Inactive')</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
