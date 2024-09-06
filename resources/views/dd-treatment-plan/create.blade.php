@extends('layouts.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- <h3>
                        <a href="{{ route('dd-treatment-plans.index') }}" class="btn btn-outline btn-info">
                            @lang('View Treatment plan')
                        </a>
                    </h3> --}}
                    <h3>
                        <a href="{{ route('dd-treatment-plans.index') }}" class="btn btn-outline btn-info">
                            <i class="fas fa-eye"></i> @lang('View All')</a>

                    </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dd-treatment-plans.index') }}">@lang('Treatment ')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('Add Treatment Plan')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Add Treatment Plan')</h3>
                </div>
                <div class="card-body">
                    <form id="treatmentForm" class="form-material form-horizontal bg-custom"
                        action="{{ route('dd-treatment-plans.store') }}" method="POST" enctype="multipart/form-data"
                        data-parsley-validate>
                        @csrf
                        <div class="row col-12 m-0 p-0">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="title">@lang('Title') <b class="ambitious-crimson">*</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                        </div>
                                        <input type="text" id="title" name="title" value="{{ old('title') }}"
                                            class="form-control @error('title') is-invalid @enderror"
                                            placeholder="@lang('Title')" required data-parsley-required="true"
                                            data-parsley-required-message="Please enter treatment's title."
                                            data-parsley-pattern="^[a-zA-Z\s]+$" data-parsley-trigger="focusout">
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
                                            value="{{ old('description') }}"
                                            class="form-control @error('description') is-invalid @enderror"
                                            placeholder="@lang('Description')" data-parsley-pattern="^[a-zA-Z\s]+$"
                                            data-parsley-trigger="focusout">
                                        @error('description')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>


                <div class="form-group">
                    <label class="col-md-3 col-form-label"></label>
                    <div class="col-md-8">
                        <input type="submit" value="{{ __('Submit') }}" class="btn btn-outline btn-info btn-lg" />
                        <a href="{{ route('dd-treatment-plans.index') }}"
                            class="btn btn-outline btn-warning btn-lg">{{ __('Cancel') }}</a>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection
