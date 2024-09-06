@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3><a href="{{ route('insurance-providers.index') }}" class="btn btn-outline btn-info">
                        <i class="fas fa-eye"></i>  @lang('View All')</a>
                        <span class="pull-right"></span>
                    </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('insurance-providers.index') }}">@lang('Insurances')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('Add Insurance')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Add Insurance')</h3>
                </div>
                <div class="card-body">
                    <form id="insuranceProviderForm" class="form-material form-horizontal bg-custom"
                    action="{{ route('insurance-providers.update', $insuranceProvider->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row col-12 m-0 p-0">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3">
                            <div class="form-group">
                                <label for="name">@lang('Name') <b class="ambitious-crimson">*</b></label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                    </div>
                                    <input type="text" id="name" name="name" value="{{ old('name',$insuranceProvider->name) }}"
                                        class="form-control @error('name') is-invalid @enderror"
                                        placeholder="@lang('John Doe')" required>
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3">
                            <div class="form-group">
                                <label for="email" class="email-label">
                                    @lang('Email') <b class="ambitious-crimson">*</b>
                                </label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-at"></i></span>
                                    </div>
                                    <input type="email" id="email" name="email" value="{{ old('email',$insuranceProvider->email) }}"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="@lang('example@gmail.com')" required>
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3">
                            <div class="form-group">
                                <label for="phone">@lang('Phone')</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    </div>
                                    <input type="number" id="phone" name="phone" value="{{ old('phone',$insuranceProvider->phone) }}"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        placeholder="@lang('03375544887')">
                                    @error('phone')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3">
                            <div class="form-group">
                                <label for="website">@lang('Website')</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    </div>
                                    <input type="url" id="website" name="website" value="{{ old('website',$insuranceProvider->website) }}"
                                    class="form-control @error('website') is-invalid @enderror"
                                    placeholder="@lang('http://example.com')">
                                    @error('website')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3">
                            <div class="form-group">
                                <label for="address">@lang('Address')</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                                    </div>
                                    <input type="text" id="address" name="address" value="{{ old('address',$insuranceProvider->address) }}"
                                        class="form-control @error('address') is-invalid @enderror"
                                        placeholder="@lang('Abc Town')">
                                </div>
                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3">
                            <div class="form-group">
                                <label for="rating">Rating</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-file"></i></span>
                                    </div>
                                    <input type="number" id="rating" name="rating" value="{{ old('rating',$insuranceProvider->rating) }}"
                                        class="form-control min="0" max="5" @error('rating') is-invalid @enderror"
                                        placeholder="@lang('0-5')">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row col-12 m-0 p-0">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 col-form-label"></label>
                                <div class="col-md-8">
                                    <input type="submit" value="{{ __('Update') }}"
                                        class="btn btn-outline btn-info btn-lg" />
                                    <a href="{{ route('doctor-details.index') }}"
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
