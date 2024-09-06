@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3>
                        <a href="{{ route('dd-medicine.index') }}" class="btn btn-outline btn-info">
                            <i class="fas fa-eye"></i> @lang('View All')
                        </a>
                        <span class="pull-right"></span>
                    </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dd-medicine.index') }}">@lang('All Medicines')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('Add New Medicine')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Add New Medicine')</h3>
                </div>
                <div class="card-body">
                    <form id="medicineForm" class="form-material form-horizontal bg-custom" action="{{ route('dd-medicine.store') }}" method="POST" enctype="multipart/form-data" data-parsley-validate>
                        @csrf
                        <div class="row col-12 m-0 p-0">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">@lang('Name') <b class="ambitious-crimson">*</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                        </div>
                                        <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="@lang('Name')" required data-parsley-required="true"
                                        data-parsley-required-message="Please enter medicine name."data-parsley-trigger="change focusout">
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="description">@lang('Description') <b class="ambitious-crimson">*</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                        </div>
                                        <input type="text" id="description" name="description" value="{{ old('description') }}" class="form-control @error('description') is-invalid @enderror" placeholder="@lang('Description')" required data-parsley-required="true"
                                        data-parsley-required-message="Please enter medicine Description."data-parsley-trigger="change focusout">
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
                                    <label for="dd_medicine_type">@lang('Medicine Type')</label>
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-pills"></i></span>
                                        </div>
                                        <select id="dd_medicine_type" name="dd_medicine_type" class="form-control @error('dd_medicine_type') is-invalid @enderror"
                                        data-parsley-required-message="Please select medicine type."data-parsley-trigger="change focusout">
                                            <option value="">@lang('Select Medicine Type')</option>
                                            @foreach ($ddMedicineTypes as $type)
                                                <option value="{{ $type->id }}" {{ old('dd_medicine_type') == $type->id ? 'selected' : '' }}>
                                                    {{ ucfirst($type->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('dd_medicine_type')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row col-12 m-0 p-0">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="col-md-12 pt-2">
                                        <input type="submit" value="{{ __('Submit') }}" class="btn btn-outline btn-info btn-lg"/>
                                        <a href="{{ route('dd-medicine.index') }}" class="btn btn-outline btn-warning btn-lg">{{ __('Cancel') }}</a>
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
