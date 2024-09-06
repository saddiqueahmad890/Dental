@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3><a href="{{ route('doctor-schedules.index') }}" class="btn btn-outline btn-info">
                            <i class="fas fa-eye"></i>@lang('View All')</a>
                        <span class="pull-right"></span>
                    </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('doctor-schedules.index') }}">@lang('Doctor Schedule')</a>
                        </li>
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
                </div>
                <div class="card-body">
                    <form id="scheduleForm" class="form-material form-horizontal bg-custom"
                    action="{{ route('doctor-schedules.store') }}" method="POST" enctype="multipart/form-data"
                    data-parsley-validate>
                    @csrf
                    <div class="row col-12 p-0 m-0">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="user_id">@lang('Select Doctor') <b class="ambitious-crimson">*</b></label>
                                <div class="form-group input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                    </div>
                                    <select name="user_id"
                                        class="form-control select2 @error('user_id') is-invalid @enderror"
                                        id="user_id" required data-parsley-required-message="Please select a doctor.">
                                        <option value="">--@lang('Select')--</option>
                                        @foreach ($doctors as $doctor)
                                            <option value="{{ $doctor->id }}"
                                                {{ (isset($selectedDoctorId) && $selectedDoctorId == $doctor->id) || old('user_id') == $doctor->id ? 'selected' : '' }}>
                                                {{ $doctor->name }}
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
                            <div class="form-group">
                                <label for="weekday">@lang('Select Weekday') <b class="ambitious-crimson">*</b></label>
                                <div class="form-group input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-calendar-day"></i></span>
                                    </div>
                                    <select name="weekday" class="form-control @error('weekday') is-invalid @enderror"
                                        id="weekday" required
                                        data-parsley-required-message="Please select a weekday.">
                                        <option value="">--@lang('Select')--</option>
                                        @foreach (config('constant.weekdays') as $weekday)
                                            <option value="{{ $weekday }}"
                                                {{ old('weekday') == $weekday ? 'selected' : '' }}>@lang($weekday)
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('weekday')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-12 p-0 m-0">
                        <label class="col-md-3 col-form-label"></label>
                        <div class="col-md-8">
                            <input type="submit" id="submit-btn" value="{{ __('Submit') }}"
                                class="btn btn-outline btn-info btn-lg mb-2" />
                            <a href="{{ route('doctor-schedules.index') }}"
                                class="btn btn-outline btn-warning btn-lg mb-2">{{ __('Cancel') }}</a>
                        </div>
                    </div>
                </form>

                </div>
            </div>
        </div>
    </div>
@endsection
