@extends('layouts.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @can('inventory-create')
                        <h3>
                            <a href="{{ route('inventories.create') }}" class="btn btn-outline btn-info">
                                + @lang('Add Inventory')
                            </a>
                        </h3>
                    @endcan
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
                    <div class="card-tools">
                        <a class="btn btn-primary float-right" target="_blank"
                            href="{{ route('inventories.index') }}?export=1">
                            <i class="fas fa-cloud-download-alt"></i> @lang('Export')
                        </a>
                        <button class="btn btn-default" data-toggle="collapse" href="#filter">
                            <i class="fas fa-filter"></i> @lang('Filter')
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="filter" class="collapse @if (request()->has('isFilterActive')) show @endif">
                        <div class="card-body border">

                            <form action="{{ route('inventories.index') }}" method="get" role="form"
                                autocomplete="off">
                                <input type="hidden" name="isFilterActive" value="true">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>@lang('Item')</label>
                                            <input type="text" name="item_id" class="form-control"
                                                value="{{ request()->input('item_id') }}" placeholder="@lang('Item')">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>@lang('Category')</label>
                                            <input type="text" name="category_id" class="form-control"
                                                value="{{ request()->input('category_id') }}"
                                                placeholder="@lang('Category')">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>@lang('SubCategory')</label>
                                            <input type="text" name="subcategory_id" class="form-control"
                                                value="{{ request()->input('subcategory_id') }}"
                                                placeholder="@lang('SubCategory')">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>@lang('Start Date')</label>
                                            <input type="text" name="start_date" id="start_date"
                                                class="form-control flatpickr" placeholder="@lang('Start Date')"
                                                value="{{ old('start_date', request()->start_date) }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>@lang('End Date')</label>
                                            <input type="text" name="end_date" id="end_date"
                                                class="form-control flatpickr" placeholder="@lang('End Date')"
                                                value="{{ old('end_date', request()->end_date) }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 align-content-center">
                                        <button type="submit" class="btn btn-info mt-4">@lang('Submit')</button>
                                        @if (request()->has('isFilterActive'))
                                            <a href="{{ route('inventories.index') }}"
                                                class="btn btn-secondary mt-4">@lang('Clear')</a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>




                    <table class="table table-striped" id="laravel_datatable">
                        <thead>
                            <tr>

                                <th>@lang('Item')</th>
                                <th>@lang('Category')</th>
                                <th>@lang('SubCategory')</th>
                                <th>@lang('Quantity')</th>
                                <th>@lang('Unit Price')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1 @endphp
                            @foreach ($inventories as $inventory)
                                <tr>

                                    <td><span>{{ $inventory->item->title ?? '-' }}</span></td>
                                    <td>{{ $inventory->category->title ?? '-' }}</td>
                                    <td>{{ $inventory->subcategory->title ?? '-' }}</td>
                                    <td>{{ $inventory->quantity }}</td>
                                    <td>{{ $inventory->unitprice }}</td>

                                    <td class="responsive-width">
                                        <a href="{{ route('inventories.show', $inventory) }}"
                                            class="responsive-width-item btn btn-info btn-outline btn-circle btn-lg align-content-center"
                                            data-toggle="tooltip" title="@lang('View')"><i class="fa fa-eye"></i></a>
                                        @can('inventory-update')
                                            <a href="#" data-id="{{ $inventory->id }}"
                                                data-item="{{ $inventory->item->title ?? '-' }}"
                                                data-category="{{ $inventory->category->title ?? '-' }}"
                                                data-subcategory="{{ $inventory->subcategory->title ?? '-' }}"
                                                data-quantity="{{ $inventory->quantity }}"
                                                class="btn btn-danger btn-outline btn-circle btn-lg align-content-center"
                                                data-toggle="tooltip" title="@lang('Consume')">
                                                <i class="fa fa-check"></i>
                                            </a>
                                        @endcan




                                        @can('inventory-delete')
                                            <form action="{{ route('inventories.destroy', $inventory) }}" method="POST"
                                                style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="responsive-width-item  btn btn-info btn-outline btn-circle btn-lg"
                                                    data-toggle="tooltip" title="@lang('Delete')">
                                                    <i class="fa fa-trash ambitious-padding-btn"></i>
                                                </button>
                                            </form>
                                        @endcan

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $inventories->links() }}
                </div>
            </div>
        </div>
    </div>
 
    <div class="modal fade" id="consumeModal" tabindex="-1" role="dialog" aria-labelledby="consumeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="consumeModalLabel">@lang('Consume Inventory')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="consumeForm" method="POST" action="{{ route('inventories.consume') }}">
                    @csrf
                    <input type="hidden" name="inventory_id" id="inventory_id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="item_title">@lang('Item Title')</label>
                                <input type="text" id="item_title" class="form-control" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="category">@lang('Category')</label>
                                <input type="text" id="category" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="subcategory">@lang('SubCategory')</label>
                                <input type="text" id="subcategory" class="form-control" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="available_quantity">@lang('Available Quantity')</label>
                                <input type="number" id="available_quantity" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="consume_quantity">@lang('Quantity to Consume')</label>
                            <input type="number" name="quantity" id="consume_quantity" class="form-control" required>
                            <div class="invalid-feedback">
                                @lang('Quantity cannot be greater than the existing inventory.')
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn-primary">@lang('Consume')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.btn-danger').on('click', function(e) {
                e.preventDefault();

                var inventoryId = $(this).data('id');
                var item = $(this).data('item');
                var category = $(this).data('category');
                var subcategory = $(this).data('subcategory');
                var quantity = $(this).data('quantity');

                // Populate the modal fields
                $('#inventory_id').val(inventoryId);
                $('#item_title').val(item);
                $('#category').val(category);
                $('#subcategory').val(subcategory);
                $('#available_quantity').val(quantity);
                $('#consume_quantity').attr('max', quantity);

                // Show the modal
                $('#consumeModal').modal('show');
            });

            $('#consumeForm').on('submit', function(e) {
                var quantity = $('#consume_quantity').val();
                var maxQuantity = $('#consume_quantity').attr('max');

                if (parseInt(quantity) > parseInt(maxQuantity)) {
                    e.preventDefault();
                    $('#consume_quantity').addClass('is-invalid');
                } else {
                    $('#consume_quantity').removeClass('is-invalid');
                }
            });
        });
    </script>

    @include('layouts.delete_modal')
@endsection
