@extends('layouts.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6 d-flex">
                    <h3 class="mr-2">
                        <a href="{{ route('inventories.create') }}" class="btn btn-outline btn-info">
                            + @lang('Add Inventory')
                        </a>
                    </h3>
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
                            <h3 class="card-title d-inline">@lang('Update Inventories')</h3>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form id="subcategoryForm" class="form-material form-horizontal bg-custom"
                        action="{{ route('inventories.update', $inventory->id) }}" method="POST"
                        enctype="multipart/form-data" data-parsley-validate>
                        @csrf
                        @method('PUT')

                        <div class="row col-12 m-0 p-0">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="category_id">@lang('Category') <b class="text-danger">*</b></label>
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-folder"></i></span>
                                        </div>
                                        <select id="category_id" name="category_id"
                                            class="form-control @error('category_id') is-invalid @enderror" required
                                            data-parsley-required="true" data-parsley-required-message="@lang('Category is required')"
                                            disabled>
                                            <option value="{{ $inventory->category_id }}">{{ $inventory->category->title }}
                                            </option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->title }}</option>
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
                                            class="form-control @error('subcategory_id') is-invalid @enderror" disabled>
                                            <option value="{{ $inventory->subcategory_id }}">
                                                {{ $inventory->subcategory->title ?? '-' }}</option>
                                            @foreach ($subCategories as $subcategory)
                                                <option value="{{ $subcategory->id }}">{{ $subcategory->title }}</option>
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
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="item_id">@lang('Item') <b class="text-danger">*</b></label>
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-box-open"></i></span>
                                        </div>
                                        <select id="item_id" name="item_id"
                                            class="form-control @error('item_id') is-invalid @enderror" required
                                            data-parsley-required="true" data-parsley-required-message="@lang('Item is required')"
                                            disabled>
                                            <option value="{{ $inventory->item_id }}">{{ $inventory->item->title }}
                                            </option>
                                            @foreach ($items as $item)
                                                <option value="{{ $item->id }}">{{ $item->title }}</option>
                                            @endforeach
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
                                            id="quantity" name="quantity" value="{{ $inventory->quantity }}"
                                            placeholder="0" required data-parsley-required="true"
                                            data-parsley-required-message="@lang('Quantity is required')" data-parsley-type="number"
                                            data-parsley-type-message="@lang('Quantity must be a number')" disabled>
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
                                        <input type="number"
                                            class="form-control @error('unitprice') is-invalid @enderror" id="unitprice"
                                            name="unitprice" value="{{ $inventory->unitprice }}" placeholder="0"
                                            required data-parsley-required="true" data-parsley-type="number"
                                            data-parsley-min="0" data-parsley-min-message="@lang('Unit price must be a positive number')" disabled>
                                    </div>
                                    @error('unitprice')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        {{-- <div class="row col-12 m-0 p-0">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="col-md-8 offset-md-0">
                                    <button type="submit" class="btn btn-outline btn-info btn-lg" disabled>
                                        {{ __('Update') }}
                                    </button>
                                    <a href="{{ route('inventories.index') }}"
                                        class="btn btn-outline btn-warning btn-lg">
                                        {{ __('Cancel') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    </form>
                </div>
                <br><br><br>
                <div class="card">
                    <div class="card-header">
                        <h5>Update Quantity</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ URL::to('consumedQuantity') }}" method="POST">
                            @csrf
                            <input type="hidden" name="inventory_id" value="{{ $inventory->id }}">
                            <input type="hidden" name="username" value="{{ Auth::user()->name }}">
                            <input type="number" placeholder="Enter Quantity" name="quantity"
                                max="{{ $inventory->quantity }}" min="1" class="form-control"><br>
                            <input type="hidden" value="{{ $inventory->id }}" name="inventory_id">
                            <input type="submit" value="Submit">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Quantity</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($consumeInventorys as $consumeInventory)
                    <tr>
                        <td>{{ $consumeInventory->created->name ?? ' ' }}</td>
                        <td>{{ $consumeInventory->quantity }}</td>
                        <td>{{ $consumeInventory->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <div class="container mt-2">
        @canany(['userlog-read'])
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">User Logs</h3>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Action</th>
                            <th>Table</th>
                            <th>Column</th>
                            <th>Old Value</th>
                            <th>New Value</th>
                            <th>Timestamp</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $log)
                            <tr>
                                <td>{{ $log->user->name }}</td>
                                <td>{{ $log->action }}</td>
                                <td>{{ $log->table_name }}</td>
                                <td>{{ $log->field_name }}</td>
                                <td>{{ $log->old_value }}</td>
                                <td>{{ $log->new_value }}</td>
                                <td>{{ $log->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endcanany
    </div>
@endsection
