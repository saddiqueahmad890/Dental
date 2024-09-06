@extends('layouts.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>
                        <a href="{{ route('items.index') }}" class="btn btn-outline btn-info">
                            <i class="fas fa-eye"></i> @lang('View All')
                        </a>
                    </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('items.index') }}">@lang('Item')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('Add Item')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Add Item')</h3>
                </div>
                <div class="card-body">
                    <form id="itemForm" class="form-material form-horizontal bg-custom" action="{{ route('items.store') }}"
                        method="POST" enctype="multipart/form-data" data-parsley-validate>
                        @csrf
                        <div class="row col-12 m-0 p-0">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="category_id">@lang('Main Category') <b class="text-danger"></b></label>
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-folder"></i></span>
                                        </div>
                                        <select id="category_id" name="category_id"
                                            class="form-control select2 @error('category_id') is-invalid @enderror"
                                            data-parsley-trigger="change focusout"
                                            data-parsley-required-message="Please select category." data-parsley-required="true">
                                            <option value="">@lang('Select category')</option>
                                            @foreach ($categories as $category)
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="subcategory_id">@lang('Sub Category')</label>
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-thermometer-half"></i></span>
                                        </div>
                                        <select id="subcategory_id" name="subcategory_id"
                                            class="form-control @error('subcategory_id') is-invalid @enderror"
                                            data-parsley-trigger="change focusout">
                                            <option value="">@lang('Select subcategory')</option>
                                            @foreach ($subcategories as $subcategory)
                                                <option value="{{ $subcategory->id }}"
                                                    {{ old('subcategory_id') == $subcategory->id ? 'selected' : '' }}>
                                                    {{ $subcategory->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('subcategory_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="item_code">@lang('Item Code') <b class="text-danger">*</b></label>
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                                        </div>
                                        <input type="number" id="item_code" name="item_code"
                                            value="{{ old('item_code') }}"
                                            class="form-control @error('item_code') is-invalid @enderror"
                                            placeholder="@lang('Item Code')"
                                            data-parsley-required-message="Please enter item code." required data-parsley-required="true"
                                            data-parsley-trigger="change focusout">
                                    </div>
                                    @error('item_code')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row col-12 m-0 p-0">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="title">@lang('Title') <b class="text-danger">*</b></label>
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                        </div>
                                        <input type="text" id="title" name="title" value="{{ old('title') }}"
                                            class="form-control @error('title') is-invalid @enderror"
                                            placeholder="@lang('Title')" required data-parsley-required="true"
                                            data-parsley-required-message="Please enter item's title."
                                            data-parsley-trigger="change focusout">
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
                                    <label for="quantity">@lang('Quantity') <b class="text-danger">*</b></label>
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calculator"></i></span>
                                        </div>
                                        <input type="number" id="quantity" name="quantity" value="{{ old('quantity') }}"
                                            class="form-control @error('quantity') is-invalid @enderror"
                                            placeholder="@lang('Quantity')" required data-parsley-required="true"
                                            data-parsley-required-message="Please enter quantity."
                                            data-parsley-trigger="change focusout">
                                    </div>
                                    @error('quantity')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row col-12 m-0 p-0">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">@lang('Description')</label>
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-file"></i></span>
                                        </div>
                                        <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror"
                                            rows="5" placeholder="@lang('Description')">{{ old('description') }}</textarea>
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
                            <div class="col-md-12">
                                <input type="submit" value="@lang('Submit')" class="btn btn-outline btn-info btn-lg">
                                <a href="{{ route('items.index') }}"
                                    class="btn btn-outline btn-warning btn-lg">@lang('Cancel')</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#category_id').change(function() {
                var categoryId = $(this).val();

                if (categoryId) {
                    $.ajax({
                        url: '{{ route('getsubcategories') }}',
                        type: 'GET',
                        data: {
                            category_id: categoryId
                        },
                        success: function(response) {
                            $('#subcategory_id').empty();
                            $('#subcategory_id').append(
                                '<option value="">@lang('Select subcategory')</option>');
                            $.each(response, function(key, value) {
                                $('#subcategory_id').append('<option value="' + value
                                    .id + '">' + value.title + '</option>');
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                } else {
                    $('#subcategory_id').empty();
                    $('#subcategory_id').append('<option value="">@lang('Select subcategory')</option>');
                }
            });
        });
    </script>
@endsection
