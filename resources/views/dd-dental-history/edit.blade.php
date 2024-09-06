@extends('layouts.layout')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6 d-flex">
                <h3 class="mr-2">
                    <a href="{{ route('dd-dental-history.create') }}" class="btn btn-outline btn-info">
                        + @lang('Add Dental History')
                    </a>
                    <span class="pull-right"></span>
                </h3>
                <h3><a href="{{ route('dd-dental-history.index') }}" class="btn btn-outline btn-info">
                    <i class="fas fa-eye"></i> @lang('View All')</a>
                <span class="pull-right"></span>
            </h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dd-dental-history.index') }}">@lang('Dental History')</a></li>
                    <li class="breadcrumb-item active">@lang('Edit Dental History')</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info">
                <h3 class="card-title">Edit Dental History ({{ $DdDentalHistory->title }})</h3>
            </div>
            <div class="card-body">
                <form id="departmentForm" class="form-material form-horizontal bg-custom"
    action="{{ route('dd-dental-history.update', $DdDentalHistory) }}" method="POST" enctype="multipart/form-data"
    data-parsley-validate>
    @csrf
    @method('PUT')

    <div class="row col-12 m-0 p-0">
        <div class="col-md-4">
            <div class="form-group">
                <label for="name">@lang('Title') <b class="ambitious-crimson">*</b></label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-signature"></i></span>
                    </div>
                    <input type="text" id="name" name="title"
                        value="{{ old('title', $DdDentalHistory->title) }}"
                        class="form-control @error('title') is-invalid @enderror"
                        placeholder="@lang('Title')" required
                        data-parsley-required-message="Please enter dental history title."
                        data-parsley-required-message="@lang('Please enter the title.')">
                    @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="email">@lang('Description')</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-file"></i></span>
                    </div>
                    <input type="text" id="email" name="description"
                        value="{{ old('description', $DdDentalHistory->description) }}"
                        class="form-control @error('description') is-invalid @enderror"
                        placeholder="@lang('Description')"
                        data-parsley-maxlength="255"
                        data-parsley-maxlength-message="@lang('Description must be 255 characters or less.')">
                    @error('description')
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
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-bell"></i></span>
                    </div>
                    <select class="form-control ambitious-form-loading @error('status') is-invalid @enderror"
                        required name="status" id="status"
                        data-parsley-required-message="@lang('Please select a status.')">
                        <option value="1" {{ old('status', $DdDentalHistory->status) === '1' ? 'selected' : '' }}>
                            @lang('Active')</option>
                        <option value="0" {{ old('status', $DdDentalHistory->status) === '0' ? 'selected' : '' }}>
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

                    <div class="row col-12 m-0 p-0">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-md-3 col-form-label"></label>
                                <div class="col-md-8 ">
                                    <input type="submit" value="{{ __('Update') }}" class="btn btn-outline btn-info btn-lg"/>
                                    <a href="{{ route('dd-dental-history.index') }}" class="btn btn-outline btn-warning btn-lg">{{ __('Cancel') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="card mt-5">
    <div class="card-header bg-info">
        <h3 class="card-title">User Logs</h3>
    </div>
    <div class="card-body">
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
                        <td>{{ $log->user->id }}</td>
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
</div>

<script src="{{ asset('assets/js/custom/doctor-detail.js') }}"></script>

@endsection
