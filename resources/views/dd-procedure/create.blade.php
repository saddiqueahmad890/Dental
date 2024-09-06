@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3>
                        <a href="{{ route('dd-procedures.index') }}" class="btn btn-outline btn-info">
                            <i class="fas fa-eye"></i> @lang('View All')
                        </a>
                        <span class="pull-right"></span>
                    </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dd-procedures.index') }}">@lang('All Options')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('Add New Procedure')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Add New Procedure')</h3>
                </div>
                <div class="card-body">
                    <form id="departmentForm" class="form-material form-horizontal bg-custom"
                        action="{{ route('dd-procedures.store') }}" method="POST" data-parsley-validate>
                        @csrf
                        <div class="row col-12 m-0 p-0">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                                <div class="form-group">
                                    <label for="title">@lang('Title') <b class="ambitious-crimson">*</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                        </div>
                                        <input type="text" id="title" name="title" value="{{ old('title') }}"
                                            class="form-control @error('title') is-invalid @enderror"
                                            placeholder="@lang('Title')" required data-parsley-required="true"
                                            data-parsley-required-message="Please enter procedure title."
                                            data-parsley-trigger="focusout">
                                        @error('title')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                                <div class="form-group">
                                    <label for="description">@lang('Description')</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-file"></i></span>
                                        </div>
                                        <input type="text" id="description" name="description"
                                            value="{{ old('description') }}"
                                            class="form-control @error('description') is-invalid @enderror"
                                            placeholder="@lang('Description')" data-parsley-trigger="focusout">
                                        @error('description')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                                <div class="form-group">
                                    <label for="price">@lang('Price') <b class="ambitious-crimson">*</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                        </div>
                                        <input type="text" id="price" name="price" value="{{ old('price') }}"
                                            class="form-control @error('price') is-invalid @enderror"
                                            placeholder="@lang('Price')" required data-parsley-required="true"
                                            data-parsley-required-message="Please enter price."
                                            data-parsley-type="number" data-parsley-trigger="focusout">
                                        @error('price')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                                <div class="form-group">
                                    <label for="sr_no">@lang('Sr No') <b class="ambitious-crimson">*</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                                        </div>
                                        <input type="text" id="sr_no" name="sr_no" value="{{ old('sr_no') }}"
                                            class="form-control @error('sr_no') is-invalid @enderror"
                                            placeholder="@lang('Sr No')" required data-parsley-required="true"
                                            data-parsley-required-message="Please enter sr no."
                                            data-parsley-trigger="focusout">
                                        @error('sr_no')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                                <div class="form-group">
                                    <label for="procedure_code">@lang('Procedure Code') <b
                                            class="ambitious-crimson">*</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                                        </div>
                                        <input type="text" id="procedure_code" name="procedure_code"
                                            value="{{ old('procedure_code') }}"
                                            class="form-control @error('procedure_code') is-invalid @enderror"
                                            placeholder="@lang('Procedure Code')" required data-parsley-required="true"
                                            data-parsley-required-message="Please enter procedure code."
                                            data-parsley-trigger="focusout">
                                        @error('procedure_code')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                                <div class="form-group">
                                    <label for="dd_procedure_id">@lang('Procedure Category') <b
                                            class="ambitious-crimson">*</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-folder"></i></span>
                                        </div>
                                        <select id="dd_procedure_id" name="dd_procedure_id"
                                            class="form-control @error('dd_procedure_id') is-invalid @enderror" required
                                            data-parsley-required="true" data-parsley-trigger="change"
                                            data-parsley-required-message="Please select procedure category.">
                                            <option value="">{{ __('Select a Procedure Category') }}</option>
                                            @foreach ($ddProcedures as $procedure)
                                                <option value="{{ $procedure->id }}">{{ $procedure->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('dd_procedure_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row col-12 m-0 p-0">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="col-md-8 pt-2">
                                        <input type="submit" value="{{ __('Submit') }}"
                                            class="btn btn-outline btn-info btn-lg" />
                                        <a href="{{ route('dd-procedures.index') }}"
                                            class="btn btn-outline btn-warning btn-lg">{{ __('Cancel') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
