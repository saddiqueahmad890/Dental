@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3>
                        <a href="{{ route('dd-blood-groups.index') }}" class="btn btn-outline btn-info"><i
                                class="fas fa-eye"></i> @lang('View All')</a>

                    </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dd-blood-groups.index') }}">@lang('Blood Groups')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('Add Blood Groups')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Add New Blood Group')</h3>
                </div>
                <div class="card-body">
                    {{-- <form id="departmentForm" class="form-material form-horizontal bg-custom"
                        action="{{ route('dd-blood-groups.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row col-12 m-0 p-0">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group">
                                    <label for="name">@lang('Name') <b class="ambitious-crimson">*</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                        </div>
                                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                                            class="form-control @error('name') is-invalid @enderror"
                                            placeholder="@lang('Name')" required>
                                        @error('name')
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
                                    <label class="col-md-3 col-form-label"></label>
                                    <div class="col-md-8">
                                        <input type="submit" value="{{ __('Submit') }}"
                                            class="btn btn-outline btn-info btn-lg" />
                                        <a href="{{ route('dd-blood-groups.index') }}"
                                            class="btn btn-outline btn-warning btn-lg">{{ __('Cancel') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form> --}}
                    <form id="departmentForm" class="form-material form-horizontal bg-custom"
      action="{{ route('dd-blood-groups.store') }}" method="POST" enctype="multipart/form-data"
      data-parsley-validate>
    @csrf
    <div class="row col-12 m-0 p-0">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <div class="form-group">
                <label for="name">@lang('Name') <b class="ambitious-crimson">*</b></label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-signature"></i></span>
                    </div>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                           class="form-control @error('name') is-invalid @enderror"
                           placeholder="@lang('Name')" required
                           data-parsley-required="true"
                           data-parsley-required-message="Please enter blood group."
                           data-parsley-pattern="^[a-zA-Z\s]+$"
                           data-parsley-trigger="focusout">
                    @error('name')
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
                <label class="col-md-3 col-form-label"></label>
                <div class="col-md-8">
                    <input type="submit" value="{{ __('Submit') }}"
                           class="btn btn-outline btn-info btn-lg" />
                    <a href="{{ route('dd-blood-groups.index') }}"
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
