@extends('layouts.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <div class="col-sm-6 d-flex">
                        <h3 class="mr-2">
                            <a href="{{ route('categories.create') }}" class="btn btn-outline btn-info">
                                + @lang('Add Category')
                            </a>
                            <span class="pull-right"></span>
                        </h3>
                        <h3>
                            <a href="{{ route('categories.index') }}" class="btn btn-outline btn-info"> @lang('View All')</a>

                        </h3>
                    </div>
                    @can('categorie-create')
                        <h3>
                            <a href="{{ route('categories.index') }}" class="btn btn-outline btn-info">
                               <i class="fas fa-eye"></i> @lang('View Categories')
                            </a>
                            <span class="pull-right"></span>
                        </h3>
                    @endcan
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('categories.index') }}">@lang('Categorie')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('Edit Categories')</li>
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
                            <h3 class="card-title d-inline">Edit Categories ({{ $category->title }})</h3>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form id="categorieForm" class="form-material form-horizontal bg-custom"
    action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data"
    data-parsley-validate>
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
                        value="{{ old('title', $category->title) }}"
                        class="form-control @error('title') is-invalid @enderror"
                        placeholder="@lang('Title')" required
                        data-parsley-required-message="@lang('Please enter category title.')">
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
                    <input id="description" name="description"
                        class="form-control @error('description') is-invalid @enderror" rows="5"
                        placeholder="@lang('Description')"
                        value="{{ old('description', $category->description) }}"
                        data-parsley-maxlength="255"
                        data-parsley-maxlength-message="@lang('Description must be 255 characters or less.')">           </div>
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
                        data-parsley-required-message="@lang('Please select a status.')">
                        <option value="1"
                            {{ old('status', $category->status) == '1' ? 'selected' : '' }}>
                            @lang('Active')
                        </option>
                        <option value="0"
                            {{ old('status', $category->status) == '0' ? 'selected' : '' }}>
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

    <div class="row col-12 m-0 p-0">
        <div class="col-md-6">
            <div class="form-group">
                <div class="col-md-8 pt-2">
                    <button type="submit" class="btn btn-outline btn-info btn-lg">
                        {{ __('Update') }}
                    </button>
                    <a href="{{ route('categories.index') }}"
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
