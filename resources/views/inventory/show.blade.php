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
                            <i class="fas fa-eye"></i>
                            @lang('View Inventory')
                        </a>
                    </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('Dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('Inventory List')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Inventory List')</h3>
                </div>
                <div class="card-body">
                    <div id="filter" class="collapse @if (request()->has('isFilterActive')) show @endif">
                        <div class="card-body border">
                            <form action="{{ route('subcategories.index') }}" method="get" role="form"
                                autocomplete="off">
                                <input type="hidden" name="isFilterActive" value="true">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>@lang('Title')</label>
                                            <input type="text" name="title" class="form-control"
                                                value="{{ request()->input('title') }}" placeholder="@lang('Title')">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>@lang('Description')</label>
                                            <input type="text" name="description" class="form-control"
                                                value="{{ request()->input('description') }}"
                                                placeholder="@lang('Description')">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-info">@lang('Submit')</button>
                                        @if (request()->has('isFilterActive'))
                                            <a href="{{ route('subcategories.index') }}"
                                                class="btn btn-secondary">@lang('Clear')</a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="bg-custom">
                        <div class="row col-12 m-0 p-0">
                            <div class="col-6 col-sm-4 col-md-2">
                                <div class="form-group">
                                    <label for="item_id">@lang('Item') <b class="text-danger"></b></label>
                                    <p>{{ $inventory->item->title ?? '-' }}</p>
                                    @error('item_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6 col-sm-4 col-md-3">
                                <div class="form-group">
                                    <label for="category_id">@lang('Category') <b class="text-danger"></b></label>
                                    <p>{{ $inventory->category->title ?? '-' }}</p>
                                    @error('category')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6 col-sm-4 col-md-3">
                                <div class="form-group">
                                    <label for="subcategory_id">@lang('Sub Category')</label>
                                    <p>{{ $inventory->subcategory->title ?? '-' }}</p>
                                    @error('item_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-6 col-sm-4 col-md-2">
                                <div class="form-group">
                                    <label for="Quantity">@lang('Quantity') <b class="text-danger"></b></label>
                                    <p>{{ $inventory->quantity }}</p>

                                </div>
                            </div>
                            <div class="col-6 col-sm-4 col-md-2">
                                <div class="form-group">
                                    <label for="Unit Price">@lang('Unit Price') <b class="text-danger"></b></label>
                                    <p>{{ $inventory->unitprice }}</p>

                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- {{ $inventories->links() }} --}}
                </div>
            </div>
        </div>
    </div>
      <div class="container">
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>@lang('Username')</th>
                        <th>@lang('Quantity')</th>
                        <th>@lang('Time')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($consumeInventorys as $consumeInventory)
                        <tr>
                            <td>{{ $consumeInventory->createdBy->name ?? ' ' }}</td>
                            <td>{{ $consumeInventory->quantity }}</td>
                            <td>{{ $consumeInventory->created_at->format('Y-m-d H:i:s') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @include('layouts.delete_modal')
@endsection
