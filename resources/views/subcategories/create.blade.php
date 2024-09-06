@extends('layouts.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- <h3>
                        <a href="{{ route('subcategories.index') }}" class="btn btn-outline btn-info">
                            @lang('View Sub Categories')
                        </a>
                        <span class="pull-right"></span>
                    </h3> --}}
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('categories.index') }}">@lang('Categories')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('Create Sub Category')</li>
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
                            <h3 class="card-title d-inline">@lang('Create Sub Category')</h3>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    {{-- <form id="subcategoryForm" class="form-material form-horizontal"
                        action="{{ route('subcategories.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="title">@lang('Title') <b class="text-danger">*</b></label>
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                        </div>
                                    <input type="text" id="title" name="title"
                                        value="{{ old('title') }}"
                                        class="form-control @error('title') is-invalid @enderror"
                                        placeholder="@lang('Title')" required>
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
                                    <label for="category_id">@lang('Category') <b class="text-danger">*</b></label>
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-folder"></i></span>
                                        </div>
                                    <select id="category_id" name="category_id"
                                        class="form-control @error('category_id') is-invalid @enderror" required>
                                        <option value="">@lang('Select category')</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                        </div>
                                    @error('category_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>



                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">@lang('Description') <b class="text-danger"></b></label>
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-file"></i></span>
                                        </div>
                                    <textarea id="description" name="description"
                                        class="form-control @error('description') is-invalid @enderror"
                                        rows="5" placeholder="@lang('Description')"
                                        value="{{ old('description') }}}"></textarea>
                                        </div>
                                    @error('description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="col-md-8 offset-md-0">
                                        <button type="submit" class="btn btn-outline btn-info btn-lg">
                                            {{ __('Create') }}
                                        </button>
                                        <a href="{{ route('subcategories.index') }}"
                                            class="btn btn-outline btn-warning btn-lg">
                                            {{ __('Cancel') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form> --}}
                    <form id="subcategoryForm" class="form-material form-horizontal"
      action="{{ route('subcategories.store') }}" method="POST"
      enctype="multipart/form-data" data-parsley-validate>
    @csrf

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="title">@lang('Title') <b class="text-danger">*</b></label>
                <div class="form-group input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-signature"></i></span>
                    </div>
                    <input type="text" id="title" name="title"
                           value="{{ old('title') }}"
                           class="form-control @error('title') is-invalid @enderror"
                           placeholder="@lang('Title')" required
                           data-parsley-required="true"
                           data-parsley-required-message="Please enter subcategory title."
                           data-parsley-pattern="^[a-zA-Z\s]+$"
                           data-parsley-trigger="focusout">
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
                <label for="category_id">@lang('Category') <b class="text-danger">*</b></label>
                <div class="form-group input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-folder"></i></span>
                    </div>
                    <select id="category_id" name="category_id"
                            class="form-control @error('category_id') is-invalid @enderror" required
                            data-parsley-required="true"
                            data-parsley-required-message="Please select category."
                            data-parsley-trigger="focusout">
                        <option value="">@lang('Select category')</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('category_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="description">@lang('Description')</label>
                <div class="form-group input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-file"></i></span>
                    </div>
                    <textarea id="description" name="description"
                              class="form-control @error('description') is-invalid @enderror"
                              rows="5" placeholder="@lang('Description')"
                              data-parsley-trigger="focusout">{{ old('description') }}</textarea>
                </div>
                @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <div class="col-md-8 offset-md-0">
                    <button type="submit" class="btn btn-outline btn-info btn-lg">
                        {{ __('Create') }}
                    </button>
                    <a href="{{ route('subcategories.index') }}"
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
