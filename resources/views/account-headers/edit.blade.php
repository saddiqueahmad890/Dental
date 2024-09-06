@extends('layouts.layout')
@section('one_page_css')
    <link href="{{ asset('assets/css/quill.snow.css') }}" rel="stylesheet">
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6 d-flex">
                    <h3 class="mr-2">
                        <a href="{{ route('account-headers.create') }}" class="btn btn-outline btn-info">+ @lang('Add Account Header')</a>
                        <span class="pull-right"></span>
                    </h3>
                     <h3>
                        <a href="{{ route('account-headers.index') }}" class="btn btn-outline btn-info"><i class="fas fa-eye"></i> @lang('View All')</a>
                            <span class="pull-right"></span>
                     </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('account-headers.index') }}">@lang('Account Header')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('Edit Account Header')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">Edit Account Header ({{ $accountHeader->name }})</h3>
                </div>
                <div class="card-body">
                    <form id="accountForm" class="form-material form-horizontal bg-custom"
                    action="{{ route('account-headers.update', $accountHeader) }}" method="POST" data-parsley-validate>
                    @csrf
                    @method('PUT')
                    <div class="row col-12 m-0 p-0">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">@lang('Account Name') <b class="ambitious-crimson">*</b></label>
                                <div class="form-group input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                    </div>
                                    <input type="text" id="name" name="name"
                                        value="{{ old('name', $accountHeader->name) }}"
                                        class="form-control @error('name') is-invalid @enderror"
                                        placeholder="@lang('Department Name')" required
                                        data-parsley-required="true" data-parsley-trigger="change">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="type">@lang('Account Type') <b class="ambitious-crimson">*</b></label>
                                <div class="form-group input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-coins"></i></span>
                                    </div>
                                    <select
                                        class="form-control ambitious-form-loading @error('type') is-invalid @enderror"
                                        required="required" name="type" id="type"
                                        data-parsley-required="true" data-parsley-trigger="change">
                                        <option value="Credit">@lang('Credit')</option>
                                        <option value="Debit"
                                            {{ old('type', $accountHeader->type) == 'Debit' ? 'selected' : '' }}>
                                            @lang('Debit')</option>
                                    </select>
                                    @error('type')
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
                                    <select
                                        class="form-control ambitious-form-loading @error('status') is-invalid @enderror"
                                        required="required" name="status" id="status"
                                        data-parsley-required="true" data-parsley-trigger="change">
                                        <option value="1">{{ __('Active') }}</option>
                                        <option value="0"
                                            {{ old('status', $accountHeader->status) === '0' ? 'selected' : '' }}>
                                            {{ __('Inactive') }}</option>
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
                        <div class="row col-12 m-0 p-2">
                            <div class="col-md-12 description_padding_left">
                                <div class="form-group">
                                    <label for="description" class="col-md-12 col-form-label">@lang('Description')</label>
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-file"></i></span>
                                        </div>
                                        <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description">{{ old('description', $accountHeader->description ?? '') }}</textarea>
                                        </div>
                                        @error('description')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        <div class="form-group">
                            <label class="col-md-3 col-form-label"></label>
                            <div class="col-md-8">
                                <input type="submit" value="{{ __('Update') }}"
                                    class="btn btn-outline btn-info btn-lg" />
                                <a href="{{ route('hospital-departments.index') }}"
                                    class="btn btn-outline btn-warning btn-lg">{{ __('Cancel') }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/quill.js') }}"></script>
    <script src="{{ asset('assets/js/custom/account-headers.js') }}"></script>
@endsection
