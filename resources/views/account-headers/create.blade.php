@extends('layouts.layout')
@section('one_page_css')
    <link href="{{ asset('assets/css/quill.snow.css') }}" rel="stylesheet">
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
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
                        <li class="breadcrumb-item active">@lang('Add Account Header')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Add Account Header')</h3>
                </div>
                <div class="card-body">
                    {{-- <form id="accountForm" class="form-material form-horizontal bg-custom"
                        action="{{ route('account-headers.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row col-12 m-0 p-0">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">@lang('Account Name') <b class="ambitious-crimson">*</b></label>
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                        </div>
                                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                                            class="form-control @error('name') is-invalid @enderror"
                                            placeholder="@lang('Account Name')" required>
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
                                            required="required" name="type" id="type">
                                            <option value="Credit">@lang('Credit')</option>
                                            <option value="Debit" {{ old('type') == 'Debit' ? 'selected' : '' }}>
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

                        </div>
                        <div class="row col-12 m-0 p-0">
                            <div class="col-md-12 description_padding_left">
                                <div class="form-group">
                                    <label for="description" class="col-md-12 col-form-label">@lang('Description')</label>
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-file"></i></span>
                                        </div>
                                        <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description">{{ old('description') }}</textarea>
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
                                <input type="submit" value="{{ __('Submit') }}"
                                    class="btn btn-outline btn-info btn-lg" />
                                <a href="{{ route('hospital-departments.index') }}"
                                    class="btn btn-outline btn-warning btn-lg">{{ __('Cancel') }}</a>
                            </div>
                        </div>
                    </form> --}}
                    <form id="accountForm" class="form-material form-horizontal bg-custom"
    action="{{ route('account-headers.store') }}" method="POST" enctype="multipart/form-data" data-parsley-validate>
    @csrf
    <div class="row col-12 m-0 p-0">
        <div class="col-md-4">
            <div class="form-group">
                <label for="name">@lang('Account Name') <b class="ambitious-crimson">*</b></label>
                <div class="form-group input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-signature"></i></span>
                    </div>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                        class="form-control @error('name') is-invalid @enderror"
                        placeholder="@lang('Account Name')" required
                        data-parsley-required="true"
                        data-parsley-trigger="change"
                        data-parsley-pattern="^[a-zA-Z\s]+$">
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
                    <select class="form-control ambitious-form-loading @error('type') is-invalid @enderror"
                        required="required" name="type" id="type"
                        data-parsley-required="true"
                        data-parsley-trigger="change">
                        <option value="Credit">@lang('Credit')</option>
                        <option value="Debit" {{ old('type') == 'Debit' ? 'selected' : '' }}>@lang('Debit')</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="row col-12 m-0 p-0">
        <div class="col-md-12 description_padding_left">
            <div class="form-group">
                <label for="description" class="col-md-12 col-form-label">@lang('Description')</label>
                <div class="form-group input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-file"></i></span>
                    </div>
                    <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description"
                        data-parsley-trigger="change">{{ old('description') }}</textarea>
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
            <input type="submit" value="{{ __('Submit') }}" class="btn btn-outline btn-info btn-lg" />
            <a href="{{ route('hospital-departments.index') }}" class="btn btn-outline btn-warning btn-lg">{{ __('Cancel') }}</a>
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
