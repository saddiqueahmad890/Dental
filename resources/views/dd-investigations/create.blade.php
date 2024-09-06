@extends('layouts.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- <h3>
                        <a href="{{ route('dd-investigations.index') }}" class="btn btn-outline btn-info">
                            @lang('View Investigations')
                        </a>
                    </h3> --}}
                    <h3>
                        <a href="{{ route('dd-investigations.index') }}" class="btn btn-outline btn-info">
                            <i class="fas fa-eye"></i> @lang('View All')</a>

                    </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dd-investigations.index') }}">@lang('Investigation')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('Add Investigation')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Add Investigation')</h3>
                </div>
                <div class="card-body">
                    {{-- <form id="investigationsForm" class="form-material form-horizontal bg-custom" action="{{ route('dd-investigations.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row col-12 m-0 p-0">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="title">@lang('Title') <b class="ambitious-crimson">*</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                        </div>
                                        <input type="text" id="title" name="title" value="{{ old('title') }}" class="form-control @error('title') is-invalid @enderror" placeholder="@lang('Title')" required>
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
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-file"></i></span>
                                        </div>
                                    <input id="description" name="description" class="form-control @error('description') is-invalid @enderror" placeholder="@lang('Description')" value="{{ old('description') }}">
                                    </div>
                                    @error('description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>


                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="submit" value="{{ __('Submit') }}" class="btn btn-outline btn-info mr-2" />
                                <a href="{{ route('dd-investigations.index') }}" class="btn btn-outline btn-warning">{{ __('Cancel') }}</a>
                            </div>
                        </div>
                    </form> --}}
                    <form id="investigationsForm" class="form-material form-horizontal bg-custom"
                        action="{{ route('dd-investigations.store') }}" method="POST" enctype="multipart/form-data"
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
                                            data-parsley-required-message="Please enter investigation's title."
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
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-file"></i></span>
                                        </div>
                                        <input id="description" name="description"
                                            class="form-control @error('description') is-invalid @enderror"
                                            placeholder="@lang('Description')" value="{{ old('description') }}"
                                            data-parsley-pattern="^[a-zA-Z\s]+$" data-parsley-trigger="focusout">
                                    </div>
                                    @error('description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12 pt-2">
                                <input type="submit" value="{{ __('Submit') }}" class="btn btn-outline btn-info mr-2" />
                                <a href="{{ route('dd-investigations.index') }}"
                                    class="btn btn-outline btn-warning">{{ __('Cancel') }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
