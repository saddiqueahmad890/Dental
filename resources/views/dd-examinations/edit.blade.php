@extends('layouts.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6 d-flex">

                    {{-- @can('categorie-create') --}}
                    <h3 class="mr-2">
                        <a href="{{ route('dd-examinations.create') }}" class="btn btn-outline btn-info">
                            + @lang('Add Examinations')
                        </a>
                        <span class="pull-right"></span>
                    </h3>
                    <h3>
                        <a href="{{ route('dd-examinations.index') }}" class="btn btn-outline btn-info">
                            <i class="fas fa-eye"></i> @lang('View All')
                        </a>
                        <span class="pull-right"></span>
                    </h3>
                    {{-- @endcan --}}
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dd-examinations.index') }}">@lang('categorie')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('Edit categorie')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="card-title d-inline">Edit categorie ({{ $examination->title }})</h3>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form id="categorieForm" class="form-material form-horizontal bg-custom"
    action="{{ route('dd-examinations.update', $examination->id) }}" method="POST"
    enctype="multipart/form-data" data-parsley-validate>
    @csrf
    @method('PUT')

    <div class="row col-12 m-0 p-0">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
            <div class="form-group">
                <label for="title">@lang('Title') <b class="ambitious-crimson">*</b></label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-signature"></i></span>
                    </div>
                    <input type="text" id="title" name="title"
                        value="{{ old('title', $examination->title) }}"
                        class="form-control @error('title') is-invalid @enderror"
                        placeholder="@lang('Title')" required
                        data-parsley-required="true"
                        data-parsley-required-message="Please enter examination's title." data-parsley-trigger="change">
                    @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
            <div class="form-group">
                <label for="description">@lang('Description') <b class="ambitious-crimson">*</b></label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-signature"></i></span>
                    </div>
                    <input type="text" id="description" name="description"
                        value="{{ old('description', $examination->description) }}"
                        class="form-control @error('description') is-invalid @enderror"
                        placeholder="@lang('Description')" required
                        data-parsley-required="true"
                        data-parsley-required-message="Please enter dexcription." data-parsley-trigger="change">
                    @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
            <div class="form-group">
                <label for="status">@lang('Status') <b class="ambitious-crimson">*</b></label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-bell"></i></span>
                    </div>
                    <select class="form-control ambitious-form-loading select2 @error('status') is-invalid @enderror"
                        required name="status" id="status"
                        data-parsley-required="true" data-parsley-trigger="change">
                        <option value="1" {{ old('status', $examination->status) == '1' ? 'selected' : '' }}>
                            @lang('Active')
                        </option>
                        <option value="0" {{ old('status', $examination->status) == '0' ? 'selected' : '' }}>
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
                <div class="col-md-8 pt-2">
                    <button type="submit" class="btn btn-outline btn-info btn-lg">
                        {{ __('Update') }}
                    </button>
                    <a href="{{ route('dd-examinations.index') }}"
                        class="btn btn-outline btn-warning btn-lg">
                        {{ __('Cancel') }}
                    </a>
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
