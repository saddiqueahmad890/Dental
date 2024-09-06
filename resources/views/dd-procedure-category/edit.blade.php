@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6 d-flex">
                    <h3 class="mr-2">
                        <a href="{{ route('dd-procedure-categories.create') }}" class="btn btn-outline btn-info">
                            + @lang('Add Procedure Category')
                        </a>
                        <span class="pull-right"></span>
                    </h3>
                    <h3>
                        <a href="{{ route('dd-procedure-categories.index') }}" class="btn btn-outline btn-info">
                            <i class="fas fa-eye"></i>@lang('View All')
                        </a>
                        <span class="pull-right"></span>
                    </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dd-procedure-categories.index') }}">@lang('Procedure Category')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('Edit Procedure Category')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">Edit Procedure Category ({{ $ddProcedureCategory->title }})</h3>
                </div>
                <div class="card-body">
                    <form id="departmentForm" class="form-material form-horizontal bg-custom"
      action="{{ route('dd-procedure-categories.update', $ddProcedureCategory) }}" method="POST"
      data-parsley-validate>
    @csrf
    @method('PUT')

    <div class="row col-12 m-0 p-0">
        <div class="col-md-6">
            <div class="form-group">
                <label for="title">@lang('Title') <b class="ambitious-crimson">*</b></label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-signature"></i></span>
                    </div>
                    <input type="text" id="title" name="title"
                           value="{{ old('title', $ddProcedureCategory->title) }}"
                           class="form-control @error('title') is-invalid @enderror"
                           placeholder="@lang('Title')" required
                           data-parsley-required-message="Please enter category title."
                           data-parsley-trigger="change">
                    @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="description">@lang('Description')</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-file"></i></span>
                    </div>
                    <input type="text" id="description" name="description"
                           value="{{ old('description', $ddProcedureCategory->description) }}"
                           class="form-control @error('description') is-invalid @enderror"
                           placeholder="@lang('Description')"
                           data-parsley-trigger="change">
                    @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="row col-12 m-0 p-0">
        <div class="col-12">
            <div class="form-group pt-2">
                <input type="submit" value="{{ __('Update') }}"
                       class="btn btn-outline btn-info btn-lg">
                <a href="{{ route('dd-procedure-categories.index') }}"
                   class="btn btn-outline btn-warning btn-lg">{{ __('Cancel') }}</a>
            </div>
        </div>
    </div>
</form>
                </div>
            </div>
        </div>
    </div>

@endsection
