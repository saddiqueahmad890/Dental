@extends('layouts.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- @can('category-create') --}}
                    <h3>
                        <a href="{{ route('categories.create') }}" class="btn btn-outline btn-info">
                            + @lang('Add Category')
                        </a>
                        <span class="pull-right"></span>
                    </h3>
                    {{-- @endcan --}}
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('Dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('Category List')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Category List')</h3>
                    <div class="card-tools">
                        <button class="btn btn-default" data-toggle="collapse" href="#filter">
                            <i class="fas fa-filter"></i> @lang('Filter')
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="filter" class="collapse @if (request()->has('isFilterActive')) show @endif">
                        <div class="card-body border">
                            <form action="{{ route('categories.index') }}" method="get" role="form" autocomplete="off">
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
                                            <label>@lang('description')</label>
                                            <input type="text" name="description" class="form-control"
                                                value="{{ request()->input('description') }}"
                                                placeholder="@lang('description')">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 align-content-center">
                                        <button type="submit" class="btn btn-info mt-4">@lang('Submit')</button>
                                        @if (request()->has('isFilterActive'))
                                            <a href="{{ route('categories.index') }}"
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

                                <th>@lang('Title')</th>
                                <th>@lang('Description')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>

                                    <td><span style="text-wrap:nowrap;">{{ $category->title ??'-'}}</span></td>
                                    <td>{{ $category->description ??'-' }}</td>
                                    <td>
                                        @if ($category->status == '1')
                                            <span class="badge badge-pill badge-success">@lang('Active')</span>
                                        @else
                                            <span class="badge badge-pill badge-danger">@lang('Inactive')</span>
                                        @endif
                                    </td>
                                    <td class="responsive-width">
                                        <a href="{{ route('categories.show', $category) }}"
                                            class="responsive-width-item btn btn-info btn-outline btn-circle btn-lg" data-toggle="tooltip"
                                            title="@lang('Edit')"><i
                                                class="fa fa-eye ambitious-padding-btn"></i></a>
                                        {{-- @endcan --}}
                                        {{-- @can('category-update') --}}
                                        <a href="{{ route('categories.edit', $category) }}"
                                            class="responsive-width-item btn btn-info btn-outline btn-circle btn-lg" data-toggle="tooltip"
                                            title="@lang('Edit')"><i
                                                class="fa fa-edit ambitious-padding-btn"></i></a>
                                        {{-- @endcan --}}
                                        {{-- @can('category-delete') --}}
                                        <a href="#" data-href="{{ route('categories.destroy', $category) }}"
                                            class="responsive-width-item btn btn-info btn-outline btn-circle btn-lg" data-toggle="modal"
                                            data-target="#myModal" title="@lang('Delete')"><i
                                                class="fa fa-trash ambitious-padding-btn"></i></a>
                                        {{-- @endcan --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $categories->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('layouts.delete_modal')
@endsection