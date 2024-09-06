@extends('layouts.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <div class="col-sm-6 d-flex">
                        <h3 class="mr-2">
                            <a href="{{ route('dd-treatment-plans.create') }}" class="btn btn-outline btn-info">
                                + @lang('Add Treatment Plan')
                            </a>
                            <span class="pull-right"></span>
                        </h3>
                        <h3>
                            <a href="{{ route('dd-treatment-plans.index') }}" class="btn btn-outline btn-info">
                                <i class="fas fa-eye"></i> @lang('View All')</a>

                        </h3>
                    </div>
                    @can('treatment plan-create')
                        <h3>
                            <a href="{{ route('dd-treatment-plans.index') }}" class="btn btn-outline btn-info">
                                @lang('View Treatment Plans')
                            </a>
                            <span class="pull-right"></span>
                        </h3>
                    @endcan
                </div>
                <div class="col-sm-4">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dd-treatment-plans.index') }}">@lang('Treatment Plan')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('Edit Treatment Plan')</li>
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
                            <h3 class="card-title d-inline">@lang('Edit Treatment Plan')</h3>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form id="treatmentForm" class="form-material form-horizontal bg-custom"
    action="{{ route('dd-treatment-plans.update', $ddTreatmentPlan) }}"
    method="POST" data-parsley-validate>
    @csrf
    @method('PUT')

    <div class="row col-12 m-0 p-0">
        <div class="col-md-4">
            <div class="form-group">
                <label for="title">@lang('Title') <b class="text-danger">*</b></label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-signature"></i></span>
                    </div>
                    <input type="text" id="title" name="title"
                        value="{{ old('title', $ddTreatmentPlan->title) }}"
                        class="form-control @error('title') is-invalid @enderror"
                        placeholder="@lang('Title')" required
                        data-parsley-required="true"
                        data-parsley-required-message="Please enter treatment's title."
                         data-parsley-trigger="change">
                    @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="description">@lang('Description')</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-align-left"></i></span>
                    </div>
                    <input type="text" id="description" name="description"
                        value="{{ old('description', $ddTreatmentPlan->description) }}"
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

        <div class="col-md-4">
            <div class="form-group">
                <label for="status">@lang('Status') <b class="ambitious-crimson">*</b></label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-bell"></i></span>
                    </div>
                    <select class="form-control ambitious-form-loading @error('status') is-invalid @enderror"
                        required name="status" id="status"
                        data-parsley-required="true" data-parsley-trigger="change">
                        <option value="1" {{ old('status', $ddTreatmentPlan->status) == '1' ? 'selected' : '' }}>
                            @lang('Active')
                        </option>
                        <option value="0" {{ old('status', $ddTreatmentPlan->status) == '0' ? 'selected' : '' }}>
                            @lang('Inactive')
                        </option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

                        <div class="row col-12 m-0 p-0">
                            <div class="col-xl-12">
                                <div class="form-group pt-2">
                                    <button type="submit" class="btn btn-outline btn-info btn-lg">
                                        {{ __('Update') }}
                                    </button>
                                    <a href="{{ route('dd-treatment-plans.index') }}"
                                        class="btn btn-outline btn-warning btn-lg">
                                        {{ __('Cancel') }}
                                    </a>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
