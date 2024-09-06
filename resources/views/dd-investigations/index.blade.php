@extends('layouts.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- @can('investigation-create') --}}
                        <h3>
                            <a href="{{ route('dd-investigations.create') }}" class="btn btn-outline btn-info">
                                + @lang('Add Investigations')
                            </a>
                            <span class="pull-right"></span>
                        </h3>
                    {{-- @endcan --}}
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('Dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('Investigation List')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Investigations List')</h3>
                    <div class="card-tools">
                        <button class="btn btn-default" data-toggle="collapse" href="#filter">
                            <i class="fas fa-filter"></i> @lang('Filter')
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="filter" class="collapse @if(request()->has('isFilterActive')) show @endif">
                        <div class="card-body border">
                            <form action="{{ route('dd-investigations.index') }}" method="get" role="form" autocomplete="off">
                                <input type="hidden" name="isFilterActive" value="true">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="title">@lang('Title')</label>
                                            <input type="text" name="title" class="form-control" value="{{ request()->input('title') }}" placeholder="@lang('Title')">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>@lang('Description')</label>
                                            <input type="text" name="description" class="form-control" value="{{ request()->input('description') }}" placeholder="@lang('Description')">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 align-content-center">
                                        <button type="submit" class="btn btn-info mt-4">@lang('Submit')</button>
                                        @if(request()->has('isFilterActive'))
                                            <a href="{{ route('dd-investigations.index') }}" class="btn btn-secondary mt-4">@lang('Clear')</a>
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
                            @foreach (  $ddInvestigations  as   $dd_investigation)
                                <tr>
                                    <td><span  style="text-wrap:nowrap;">{{  $dd_investigation->title }}</span></td>
                                    <td>{{   $dd_investigation->description }}</td>
                                       <td>
                                         @if ($dd_investigation->status == '1')
                                            <span class="badge badge-pill badge-success">@lang('Active')</span>
                                        @else
                                            <span class="badge badge-pill badge-danger">@lang('Inactive')</span>
                                        @endif
                                    </td>

                                    <td class="responsive-width">
                                        <a href="{{ route('dd-investigations.show', $dd_investigation ) }}" class="responsive-width-item btn btn-info btn-outline btn-circle btn-lg" data-toggle="tooltip" title="@lang('Edit')"><i class="fa fa-eye ambitious-padding-btn"></i></a>

                                        {{-- @endcan --}}
                                        {{-- @can('investigation-update') --}}
                                            <a href="{{ route('dd-investigations.edit',$dd_investigation ) }}" class="responsive-width-item btn btn-info btn-outline btn-circle btn-lg" data-toggle="tooltip" title="@lang('Edit')"><i class="fa fa-edit ambitious-padding-btn"></i></a>
                                        {{-- @endcan --}}
                                        {{-- @can('investigation-delete') --}}
                                            <a href="#" data-href="{{ route('dd-investigations.destroy', $dd_investigation) }}" class="responsive-width-item btn btn-info btn-outline btn-circle btn-lg" data-toggle="modal" data-target="#myModal" title="@lang('Delete')"><i class="fa fa-trash ambitious-padding-btn"></i></a>
                                        {{-- @endcan --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $ddInvestigations->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('layouts.delete_modal')
@endsection
