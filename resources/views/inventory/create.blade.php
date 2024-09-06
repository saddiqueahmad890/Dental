@extends('layouts.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>
                        <a href="{{ route('inventories.index') }}" class="btn btn-outline btn-info">
                            <i class="fas fa-eye"></i> @lang('View Inventory')
                        </a>
                        <span class="pull-right"></span>
                    </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('inventories.index') }}">@lang('Inventories')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('Create Inventory')</li>
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
                            <h3 class="card-title d-inline">@lang('Create Inventories')</h3>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <form id="inventoryForm" class="form-material form-horizontal bg-custom"
                        action="{{ route('inventories.store') }}" method="POST" enctype="multipart/form-data"
                        data-parsley-validate>
                        @csrf

                        <div class="row col-12 m-0 p-0">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="category_id">@lang('Category') <b class="text-danger">*</b></label>
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-folder"></i></span>
                                        </div>
                                        <select id="category_id" name="category_id"
                                            class="form-control @error('category_id') is-invalid @enderror" required
                                            data-parsley-required-message="@lang('Please select a category')">
                                            <option value="">@lang('Select Category')</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"> {{ $category->title }} </option>
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

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="subcategory_id">@lang('Sub Category')</label>
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-list"></i></span>
                                        </div>
                                        <select id="subcategory_id" name="subcategory_id"
                                            class="form-control @error('subcategory_id') is-invalid @enderror">
                                            <option value="">@lang('Select Sub Category')</option>
                                        </select>
                                    </div>
                                    @error('subcategory_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="item_id">@lang('Item') <b class="text-danger">*</b></label>
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-box-open"></i></span>
                                        </div>
                                        <select id="item_id" name="item_id"
                                            class="form-control @error('item_id') is-invalid @enderror" required
                                            data-parsley-required-message="@lang('Please select an item')">
                                            <option value="">@lang('Select Item')</option>
                                        </select>
                                    </div>
                                    @error('item_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="quantity">@lang('Quantity') <b class="text-danger">*</b></label>
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calculator"></i></span>
                                        </div>
                                        <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                            id="quantity" name="quantity" placeholder="0" required
                                            data-parsley-required-message="@lang('Please enter the quantity')" data-parsley-type="number"
                                            data-parsley-type-message="@lang('Quantity must be a number')">
                                    </div>
                                    @error('quantity')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="unitprice">@lang('Unit Price') <b class="text-danger">*</b></label>
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                        </div>
                                        <input type="number" class="form-control @error('unitprice') is-invalid @enderror"
                                            id="unitprice" name="unitprice" placeholder="0" required
                                            data-parsley-required-message="@lang('Please enter the unit price')" data-parsley-type="number"
                                            data-parsley-type-message="@lang('Unit Price must be a number')">
                                    </div>
                                    @error('unitprice')
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
                                    <div class="col-md-8 offset-md-0 pt-2">
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

    {{-- @push('scripts') --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            var baseUrl = '{{ url('/') }}'; // Dynamically set base URL for the project

            // URLs with placeholders
            var getSubCategoriesUrl = '{{ url('/category') }}/:categoryId/subcategories';
            var getItemsUrl = '{{ url('/category') }}/:categoryId/items';

            $('#category_id').change(function() {
                var categoryId = $(this).val();

                if (categoryId) {
                    // Update subcategory URL and fetch data
                    var subCategoriesUrl = getSubCategoriesUrl.replace(':categoryId', categoryId);
                    $.ajax({
                        url: subCategoriesUrl,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            var subcategorySelect = $('#subcategory_id');
                            subcategorySelect.empty();
                            subcategorySelect.append(
                                '<option value="">@lang('Select Sub Category')</option>');
                            $.each(data, function(key, value) {
                                subcategorySelect.append('<option value="' + value.id +
                                    '">' + value.title + '</option>');
                            });

                            // Clear items dropdown
                            $('#item_id').empty().append(
                                '<option value="">@lang('Select Item')</option>');
                        }
                    });

                    // Update items URL and fetch data
                    var itemsUrl = getItemsUrl.replace(':categoryId', categoryId);
                    $.ajax({
                        url: itemsUrl,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            var itemSelect = $('#item_id');
                            itemSelect.empty();
                            itemSelect.append('<option value="">@lang('Select Item')</option>');
                            $.each(data, function(key, value) {
                                itemSelect.append('<option value="' + value.id + '">' +
                                    value.title + '</option>');
                            });
                        }
                    });
                } else {
                    $('#subcategory_id').empty().append('<option value="">@lang('Select Sub Category')</option>');
                    $('#item_id').empty().append('<option value="">@lang('Select Item')</option>');
                }
            });

            $('#subcategory_id').change(function() {
                var subcategoryId = $(this).val();
                var categoryId = $('#category_id').val();

                if (subcategoryId && categoryId) {
                    // Update items URL and fetch data
                    var itemsUrl = getItemsUrl.replace(':categoryId', categoryId);
                    $.ajax({
                        url: itemsUrl,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            var itemSelect = $('#item_id');
                            itemSelect.empty();
                            itemSelect.append('<option value="">@lang('Select Item')</option>');
                            $.each(data, function(key, value) {
                                itemSelect.append('<option value="' + value.id + '">' +
                                    value.title + '</option>');
                            });
                        }
                    });
                } else {
                    $('#item_id').empty().append('<option value="">@lang('Select Item')</option>');
                }
            });
        });
    </script>

    {{-- @endpush --}}
@endsection
