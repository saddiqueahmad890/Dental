@extends('layouts.layout')
@section('one_page_css')
    <link href="{{ asset('assets/css/quill.snow.css') }}" rel="stylesheet">
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6 d-flex">
                    <h3 class="mr-2"><a href="{{ route('dd-blood-groups.create') }}" class="btn btn-outline btn-info">+
                            @lang('Add New Blood Group')</a>
                        <span class="pull-right"></span>
                    </h3>
                    <h3>
                        <a href="{{ route('dd-blood-groups.index') }}" class="btn btn-outline btn-info"><i
                                class="fas fa-eye"></i> @lang('View All')</a>

                    </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dd-blood-groups.index') }}">@lang('All Blood Groups')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('Edit Blood Group')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">Edit Blood Group ({{ $dd_blood_group->name }})</h3>
                </div>
                <div class="card-body">
                    <form id="blooggroupForm" class="form-material form-horizontal bg-custom"
      action="{{ route('dd-blood-groups.update', $dd_blood_group) }}" method="POST"
      enctype="multipart/form-data" data-parsley-validate>
    @csrf
    @method('PUT')

    <div class="row col-12 m-0 p-0">
        <div class="col-md-6">
            <div class="form-group">
                <label for="name">@lang('Name') <b class="ambitious-crimson">*</b></label>
                <div class="form-group input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-signature"></i></span>
                    </div>
                    <input type="text" id="name" name="name"
                           value="{{ old('name', $dd_blood_group->name) }}"
                           class="form-control @error('name') is-invalid @enderror"
                           placeholder="@lang(' Name')" required
                           data-parsley-required-message="Please enter blood group." data-parsley-trigger="change">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="status">@lang('Status') <b class="text-danger">*</b></label>
                <div class="form-group input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-bell"></i></span>
                    </div>
                    <select id="status" name="status"
                            class="form-control @error('status') is-invalid @enderror" required
                            data-parsley-required-message="Status is required" data-parsley-trigger="change">
                        <option value="1"
                            {{ old('status', $dd_blood_group->status) == '1' ? 'selected' : '' }}>
                            @lang('Active')
                        </option>
                        <option value="0"
                            {{ old('status', $dd_blood_group->status) == '0' ? 'selected' : '' }}>
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
    </div>

    <div class="row col-12 m-0 p-0">
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-3 col-form-label"></label>
                <div class="col-md-8">
                    <input type="submit" value="@lang('Update')"
                           class="btn btn-outline btn-info btn-lg" />
                    <a href="{{ route('dd-blood-groups.index') }}"
                       class="btn btn-outline btn-warning btn-lg">@lang('Cancel')</a>
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
    <script src="{{ asset('assets/js/quill.js') }}"></script>
@endpush
