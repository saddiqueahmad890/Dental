@extends('layouts.layout')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                @can('lab-report-template-create')
                    <h3><a href="{{ route('lab-report-templates.create') }}" class="btn btn-outline btn-info">+ @lang('Lab Report Template')</a>
                        <span class="pull-right"></span>
                    </h3>
                @endcan
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item active">@lang('Lab Report Template List')</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info">
                <h3 class="card-title">@lang('Lab Report Template List')</h3>
                <div class="card-tools">
                    <button class="btn btn-default" data-toggle="collapse" href="#filter"><i class="fas fa-filter"></i> @lang('Filter')</button>
                </div>
            </div>
            <div class="card-body">
                <div id="filter" class="collapse @if(request()->isFilterActive) show @endif">
                    <div class="card-body border">
                        <form action="" method="get" role="form" autocomplete="off">
                            <input type="hidden" name="isFilterActive" value="true">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>@lang('Name')</label>
                                        <input type="text" name="name" class="form-control" value="{{ request()->name }}" placeholder="@lang('Name')">
                                    </div>
                                </div>
                                <div class="col-sm-4 align-content-center">
                                    <button type="submit" class="btn btn-info mt-4">@lang('Submit')</button>
                                    @if(request()->isFilterActive)
                                        <a href="{{ route('lab-report-templates.index') }}" class="btn btn-secondary mt-4">Clear</a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <table class="table table-striped" id="laravel_datatable">
                    <thead>
                        <tr>

                            <th>@lang('Template Name')</th>
                            <th data-orderable="false">@lang('Actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($labReportTemplates as $labReportTemplate)
                        <tr>

                            <td><span style="text-wrap:nowrap;">{{ $labReportTemplate->name }}</span></td>

                            <td class="responsive-width">
                                <a href="{{ route('lab-report-templates.show', $labReportTemplate) }}" class="responsive-width-item btn btn-info btn-outline btn-circle btn-lg" data-toggle="tooltip" title="@lang('View')"><i class="fa fa-eye ambitious-padding-btn"></i></a>
                                @can('lab-report-template-update')
                                    <a href="{{ route('lab-report-templates.edit', $labReportTemplate) }}" class="responsive-width-item btn btn-info btn-outline btn-circle btn-lg" data-toggle="tooltip" title="@lang('Edit')"><i class="fa fa-edit ambitious-padding-btn"></i></a>
                                @endcan
                                @can('lab-report-template-delete')
                                    <form action="{{ route('lab-report-templates.destroy', $labReportTemplate) }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="responsive-width-item  btn btn-info btn-outline btn-circle btn-lg"
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
                {{ $labReportTemplates->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@include('layouts.delete_modal')
@endsection
