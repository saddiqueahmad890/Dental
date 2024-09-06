@extends('layouts.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <div class="col-sm-6 d-flex">
                        <h3 class="mr-2">
                            <a href="{{ route('dd-investigations.create') }}" class="btn btn-outline btn-info">
                                + @lang('Add Investigations')
                            </a>
                            <span class="pull-right"></span>
                        </h3>
                        <h3>
                            <a href="{{ route('dd-investigations.index') }}" class="btn btn-outline btn-info">
                                <i class="fas fa-eye"></i> @lang('View All')</a>

                        </h3>
                    </div>
                    @can('categorie-create')
                        <h3>
                            <a href="{{ route('dd-investigations.index') }}" class="btn btn-outline btn-info">
                                @lang('View categories')
                            </a>
                            <span class="pull-right"></span>
                        </h3>
                    @endcan
                </div>
                <div class="col-sm-4">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dd-investigations.index') }}">@lang('Investigation')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('Edit Investigation List')</li>
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
                            <h3 class="card-title d-inline">Edit Investigation List ({{ $dd_investigation->title }})</h3>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form id="categorieForm" class="form-material form-horizontal bg-custom"
                    action="{{ route('dd-investigations.update', $dd_investigation) }}" method="POST"
                    enctype="multipart/form-data" data-parsley-validate>
                    @csrf
                    @method('PUT')

                    <div class="row col-12 m-0 p-0">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="title">@lang('Title') <b class="text-danger">*</b></label>
                                <div class="form-group input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                    </div>
                                    <input type="text" id="title" name="title"
                                        value="{{ old('title', $dd_investigation->title) }}"
                                        class="form-control @error('title') is-invalid @enderror"
                                        placeholder="@lang('Title')" required data-parsley-required="true"
                                        data-parsley-required-message="Please enter investigation's title."
                                        data-parsley-required-message="Title is required">
                                </div>
                                @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="description">@lang('Description')</label>
                                <div class="form-group input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-file"></i></span>
                                    </div>
                                    <input type="text" id="description" name="description"
                                        class="form-control @error('description') is-invalid @enderror" rows="5"
                                        placeholder="@lang('Description')"
                                        value="{{ old('description', $dd_investigation->description) }}">
                                </div>
                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="status">@lang('Status') <b class="text-danger">*</b></label>
                                <div class="form-group input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-bell"></i></span>
                                    </div>
                                    <select id="status" name="status"
                                        class="form-control @error('status') is-invalid @enderror" required
                                        data-parsley-required="true" data-parsley-required-message="Status is required">
                                        <option value="1"
                                            {{ old('status', $dd_investigation->status) == '1' ? 'selected' : '' }}>
                                            @lang('Active')
                                        </option>
                                        <option value="0"
                                            {{ old('status', $dd_investigation->status) == '0' ? 'selected' : '' }}>
                                            @lang('Inactive')
                                        </option>
                                    </select>
                                </div>
                                @error('status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row col-12 m-0 p-0 mb-2">
                        <div class="col-md-12 pt-2">
                            <button type="submit" class="btn btn-outline btn-info btn-lg">
                                {{ __('Update') }}
                            </button>
                            <a href="{{ route('dd-investigations.index') }}"
                                class="btn btn-outline btn-warning btn-lg">
                                {{ __('Cancel') }}
                            </a>
                        </div>
                    </div>
                </form>

                </div>
            </div>
        </div>
    </div>

@endsection
