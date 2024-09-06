@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">

                    <h3>
                        <a href="{{ route('dd-procedures.create') }}" class="btn btn-outline btn-info">
                            + @lang('Add Procedure ')
                        </a>
                        <span class="pull-right"></span>
                    </h3>

                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('Dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('Procedure Category History')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Procedure List')</h3>
                    <div class="card-tools">
                        <button class="btn btn-default" data-toggle="collapse" href="#filter">
                            <i class="fas fa-filter"></i> @lang('Filter')
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="filter" class="collapse @if (request()->isFilterActive) show @endif">
                        <div class="card-body border">
                            <form action="" method="get" role="form" autocomplete="off">
                                <input type="hidden" name="isFilterActive" value="true">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>@lang('SR-No')</label>
                                            <input type="text" name="sr_no" class="form-control"
                                                value="{{ request()->sr_no }}" placeholder="@lang('SR-No')">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>@lang('Procedure Code')</label>
                                            <input type="text" name="procedure_code" class="form-control"
                                                value="{{ request()->procedure_code }}" placeholder="@lang('Procedure Code')">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>@lang('Title')</label>
                                            <input type="text" name="title" class="form-control"
                                                value="{{ request()->title }}" placeholder="@lang('Title')">
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-info">@lang('Submit')</button>
                                        @if (request()->isFilterActive)
                                            <a href="{{ route('dd-procedures.index') }}"
                                                class="btn btn-secondary">@lang('Clear')</a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <table class="table table-striped" id="laravel_datatable">
                        <thead>
                            <tr>

                                {{-- <th>@lang('SR-No')</th> --}}
                                <th>@lang('Procedure Category')</th>
                                <th>@lang('Procedure_Code')</th>
                                <th>@lang('Title')</th>
                                <th>@lang('Price')</th>
                                <th>@lang('Descripition')</th>



                                <th data-orderable="false">@lang('Actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ddProcedures as $ddProcedure)
                                <tr>

                                    {{-- <td>{{ $i++ }}</td> --}}
                                    <td><span style="text-wrap:nowrap;">{{ $ddProcedure->ddprocedurecategory->title ??'-' }}</span></td>
                                    <td>{{ $ddProcedure->procedure_code }}</td>
                                    <td>{{ $ddProcedure->title }}</td>
                                    <td>{{ $ddProcedure->price }}</td>
                                    <td>{{ $ddProcedure->description }}</td>


                                    <td calss="responsive-width">
                                        <a href="{{ route('dd-procedures.show', $ddProcedure) }}"
                                            class="responsive-width-item btn btn-info btn-outline btn-circle btn-lg" data-toggle="tooltip"
                                            title="@lang('View')"><i class="fa fa-eye ambitious-padding-btn"></i></a>

                                        <a href="{{ route('dd-procedures.edit', $ddProcedure) }}"
                                            class="responsive-width-item btn btn-info btn-outline btn-circle btn-lg" data-toggle="tooltip"
                                            title="@lang('Edit')"><i class="fa fa-edit ambitious-padding-btn"></i></a>


                                        <a href="#" data-href="{{ route('dd-procedures.destroy', $ddProcedure) }}"
                                            class="responsive-width-item btn btn-info btn-outline btn-circle btn-lg" data-toggle="modal"
                                            data-target="#myModal" title="@lang('Delete')"><i
                                                class="fa fa-trash ambitious-padding-btn"></i></a>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    @include('layouts.delete_modal')
@endsection
