@extends('layouts.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>
                        <a href="{{ route('items.index') }}" class="btn btn-outline btn-info">
                            @lang('View Items')
                        </a>
                    </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('items.index') }}">@lang('Item')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('Item Details')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Item Details')</h3>
                </div>
                <div class="card-body">
                    <div class="bg-custom">
                        <div class="row col-12">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="category_id">@lang('Category ID')</label>
                                    <p>{{ $item->category_id }}</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="subcategory_id">@lang('Subcategory ID')</label>
                                    <p>{{ $item->subcategory_id }}</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="item_code">@lang('Item Code')</label>
                                    <p>{{ $item->item_code }}</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="title">@lang('Title')</label>
                                    <p>{{ $item->title }}</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="quantity">@lang('Quantity')</label>
                                    <p>{{ $item->quantity }}</p>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label for="description">@lang('Description')</label>
                                    <p>{{ $item->description }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row col-12 p-2">
                            <a href="{{ route('items.edit', $item->id) }}" class="btn btn-outline btn-info  btn-lg ml-1">@lang('Edit')</a>
                            <a href="{{ route('items.index') }}" class="btn btn-outline btn-warning btn-lg ml-1">@lang('Back')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
