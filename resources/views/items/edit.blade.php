@extends('layouts.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6 d-flex">
                    <h3 class="mr-2">
                        <a href="{{ route('items.create') }}" class="btn btn-outline btn-info">
                            + @lang('Add Item')
                       </a>
                        <span class="pull-right"></span>
                    </h3>
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
                        <li class="breadcrumb-item active">@lang('Edit Item')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">Edit Item ({{ $item->category->title }})</h3>
                </div>
                <div class="card-body">
                    <form id="itemForm" class="form-material form-horizontal bg-custom"
    action="{{ route('items.update', $item->id) }}" method="POST" enctype="multipart/form-data" data-parsley-validate>
    @csrf
    @method('PUT')
    <div class="row col-12 m-0 p-0">
        <div class="col-md-4">
            <div class="form-group">
                <label for="category_id">@lang('Category') <b class="text-danger">*</b></label>
                <div class="form-group input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-folder"></i></span>
                    </div>
                    <select name="category_id"
                        class="form-control select2 @error('category_id') is-invalid @enderror"
                        id="category_id" required data-parsley-required="true" data-parsley-trigger="change"
                        data-parsley-required-message="Please select category.">
                        <option value="" disabled>Select Category</option>
                        @foreach ($categories as $categories)
                            <option value="{{ $categories->id }}"
                                @if (old('category_id', $item->category_id) == $categories->id) selected @endif>
                                {{ $categories->title }}
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
                <label for="subcategory_id">@lang('SubCategory') <b class="text-danger">*</b></label>
                <div class="form-group input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-box-open"></i></span>
                    </div>
                    <select name="subcategory_id"
                        class="form-control select2 @error('subcategory_id') is-invalid @enderror"
                        id="subcategory_id" required data-parsley-required="true" data-parsley-trigger="change">
                        <option value="" disabled>Select SubCategory</option>
                        @foreach ($subcategories as $subcategories)
                            <option value="{{ $subcategories->id }}"
                                @if (old('subcategory_id', $item->subcategory_id) == $subcategories->id) selected @endif>
                                {{ $subcategories->title }}
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
                    <input type="text" id="item_code" name="item_code"
                        value="{{ old('item_code', $item->item_code) }}"
                        class="form-control @error('item_code') is-invalid @enderror"
                        placeholder="@lang('Item Code')" required data-parsley-required="true"
                        data-parsley-required-message="Please enter item code."
                        data-parsley-trigger="change">
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
        <div class="col-md-6">
            <div class="form-group">
                <label for="title">@lang('Title') <b class="text-danger">*</b></label>
                <div class="form-group input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-signature"></i></span>
                    </div>
                    <input type="text" id="title" name="title"
                        value="{{ old('title', $item->title) }}"
                        class="form-control @error('title') is-invalid @enderror"
                        placeholder="@lang('Title')" required data-parsley-required="true"
                        data-parsley-required-message="Please enter item's title."
                        data-parsley-trigger="change">
                </div>
                @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="quantity">@lang('Quantity') <b class="text-danger">*</b></label>
                <div class="form-group input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-calculator"></i></span>
                    </div>
                    <input type="text" id="quantity" name="quantity"
                        value="{{ old('quantity', $item->quantity) }}"
                        class="form-control @error('quantity') is-invalid @enderror"
                        placeholder="@lang('Quantity')" required data-parsley-required="true"
                        data-parsley-required-message="Please enter quantity."
                        data-parsley-type="number" data-parsley-trigger="change">
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
                                        rows="5" placeholder="@lang('Description')">{{ old('description', $item->description) }}</textarea>
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
                                <input type="submit" value="@lang('Update')" class="btn btn-outline btn-info btn-lg">
                                <a href="{{ route('items.index') }}"
                                    class="btn btn-outline btn-warning btn-lg">@lang('Cancel')</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
