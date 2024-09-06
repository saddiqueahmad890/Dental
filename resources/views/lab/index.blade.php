@extends('layouts.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @can('lab-create')
                        <h3>
                            <a href="{{ route('lab.create') }}" class="btn btn-outline btn-info">
                                + @lang('Add Lab')
                            </a>
                            <span class="pull-right"></span>
                        </h3>
                    @endcan
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('Dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('Lab List')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Lab List')</h3>
                    <div class="card-tools">
                        <a class="btn btn-primary" target="_blank" href="{{ route('labs.index') }}?export=1">
                            <i class="fas fa-cloud-download-alt"></i> @lang('Export')
                        </a>
                        <button class="btn btn-default" data-toggle="collapse" href="#filter">
                            <i class="fas fa-filter"></i> @lang('Filter')
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="filter" class="collapse @if(request()->has('isFilterActive')) show @endif">
                        <div class="card-body border">
                            <form action="{{ route('labs.index') }}" method="get" role="form" autocomplete="off">
                                <input type="hidden" name="isFilterActive" value="true">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>@lang('Lab Number')</label>
                                            <input type="text" name="lab_number" class="form-control" value="{{ request()->input('lab_number') }}" placeholder="@lang('Lab Number')">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>@lang('Lab Name')</label>
                                            <input type="text" name="title" class="form-control" value="{{ request()->input('title') }}" placeholder="@lang('Lab Name')">
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>@lang('Phone No.')</label>
                                            <input type="text" name="phone_no" class="form-control" value="{{ request()->input('phone_no') }}" placeholder="@lang('Phone No.')">
                                        </div>
                                    </div>
                                       <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>@lang('Address')</label>
                                            <input type="text" name="address" class="form-control" value="{{ request()->input('address') }}" placeholder="@lang('Address')">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-info">@lang('Submit')</button>
                                        @if(request()->has('isFilterActive'))
                                            <a href="{{ route('labs.index') }}" class="btn btn-secondary">@lang('Clear')</a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <table class="table table-striped" id="laravel_datatable">
                        <thead>
                            <tr>

                                <th>@lang('Lab Number')</th>
                                <th>@lang('Lab Name')</th>
                                <th>@lang('Lab Description')</th>
                                <th>@lang('Lab Address')</th>
                                <th>@lang('Phone No.')</th>
                                <th>@lang('Action')</th>


                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($labs as $lab)
                                <tr>


                                    <td><span style="text-wrap:nowrap;">{{ $lab->lab_number  }}</span></td>
                                    <td>{{ $lab->title  }}</td>
                                    <td>{{ $lab->description }}</td>
                                    {{-- <td>{{ $labs->user->name ?? ' ' }}</td> --}}
                                    <td>{{ $lab->address }}</td>
                                    <td>{{ $lab->phone_no }}</td>
                                    <td class="responsive-width">
                                        @can('lab-update')
                                            <a href="{{ route('labs.edit', $lab) }}" class="responsive-width-item btn btn-info btn-outline btn-circle btn-lg" data-toggle="tooltip" title="@lang('Edit')"><i class="fa fa-edit ambitious-padding-btn"></i></a>
                                        @endcan

                                        @can('labs-delete')
                                            <a href="#" data-href="{{ route('labs.destroy', $lab) }}" class="responsive-width-item btn btn-info btn-outline btn-circle btn-lg" data-toggle="modal" data-target="#myModal" title="@lang('Delete')"><i class="fa fa-trash ambitious-padding-btn"></i></a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $labs->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('layouts.delete_modal')
@endsection
