@extends('layouts.layout')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('insurance-providers.index') }}">@lang('Insurances')</a></li>
                    <li class="breadcrumb-item active">@lang('Insurance Info')</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-info">
                <h3 class="card-title">@lang('Insurance')</h3>
                @can('doctor-detail-update')
                    <div class="card-tools">
                        <a href="{{ route('insurance-providers.edit', $insuranceProvider) }}" class="btn btn-info">@lang('Edit')</a>
                    </div>
                @endcan
            </div>
            <div class="card-body">
                <div class="bg-custom">
                    <div class="row m-0 p-0 col-12">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">@lang('Name')</label>
                                <p>{{ $insuranceProvider->name }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email">@lang('Email')</label>
                                <p>{{ $insuranceProvider->email }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="phone">@lang('Phone')</label>
                                <p>{{ $insuranceProvider->phone }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="address">@lang('Address')</label>
                                <p>{{ $insuranceProvider->address }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="website">@lang('Website')</label>
                                <p>{{ $insuranceProvider->website }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="rating">@lang('Rating')</label>
                                <p>{{ $insuranceProvider->rating }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
