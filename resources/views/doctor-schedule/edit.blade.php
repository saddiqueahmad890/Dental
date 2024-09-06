@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6 d-flex">
                    <h3 class="mr-2">
                        <a href="{{ route('doctor-schedules.create') }}" class="btn btn-outline btn-info">+
                            @lang('Add Schedule')</a>
                        <span class="pull-right"></span>
                    </h3>
                    <h3><a href="{{ route('doctor-schedules.index') }}" class="btn btn-outline btn-info">
                            <i class="fas fa-eye"></i> @lang('View All')</a>
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
                    <h3 class="card-title">Add Doctor Schedule ({{ $doctorSchedule->user->name }})</h3>
                </div>
                <div class="card-body">
                    <form id="scheduleForm" class="form-material form-horizontal bg-custom"
                    action="{{ route('doctor-schedules.update', $doctorSchedule) }}" method="POST"
                    enctype="multipart/form-data" data-parsley-validate>
                  @csrf
                  @method('PUT')
                  <div class="row col-12 p-0 m-0">
                      <div class="col-md-4">
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
                                              {{ old('user_id', $doctorSchedule->user_id) == $doctor->id ? 'selected' : '' }}>
                                              {{ $doctor->name }}</option>
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

                      <div class="col-md-4">
                          <div class="form-group">
                              <label for="weekday">@lang('Select Weekday') <b class="ambitious-crimson">*</b></label>
                              <div class="form-group input-group mb-3">
                                  <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="fas fa-calendar-day"></i></span>
                                  </div>
                                  <select name="weekday" class="form-control @error('weekday') is-invalid @enderror"
                                          id="weekday" required
                                          data-parsley-required-message="Please select weekday.">
                                      <option value="">--@lang('Select')--</option>
                                      @foreach (config('constant.weekdays') as $weekday)
                                          <option value="{{ $weekday }}"
                                              {{ old('weekday', $doctorSchedule->weekday) == $weekday ? 'selected' : '' }}>
                                              @lang($weekday)</option>
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
                      <div class="col-md-4">
                        <div class="form-group">
                            <label for="status">@lang('Status') <b class="ambitious-crimson">*</b></label>
                            <div class="form-group input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-bell"></i></span>
                                </div>
                                <select class="form-control @error('status') is-invalid @enderror" name="status"
                                        id="status" required
                                        data-parsley-required="@lang('The status field is required')">
                                    <option value="1"
                                        {{ old('status', $doctorSchedule->status) === '1' ? 'selected' : '' }}>
                                        @lang('Active')</option>
                                    <option value="0"
                                        {{ old('status', $doctorSchedule->status) === '0' ? 'selected' : '' }}>
                                        @lang('Inactive')</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                  </div>

                        </div>
                        <div class="form-group col-12 p-0 m-0">
                            <label class="col-md-3 col-form-label"></label>
                            <div class="col-md-8">
                                <input type="submit" value="{{ __('Update') }}"
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
    @php
    $statusMapping = [
        1 => 'Active',
        0 => 'Non Active',
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
                                @if ($log->field_name === 'status')
                                    {{ $statusMapping[$log->old_value] ?? $log->old_value }}
                                @else
                                    {{ $log->old_value }}
                                @endif
                            </td>
                            <td>
                                @if ($log->field_name === 'status')
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
@endsection
