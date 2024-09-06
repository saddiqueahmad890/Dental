@extends('layouts.layout')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1>@lang('Medical History Information')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dd-dental-history.index') }}">@lang('Social History')</a>
                    </li>
                    <li class="breadcrumb-item active">@lang('Social History Information')</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info">
                <h3 class="card-title">@lang('Dental History Information')</h3>
                <div class="card-tools">
                <a href="{{ route('dd-dental-history.edit', $DdDentalHistory) }}" class="btn btn-info">@lang('Edit')</a>
            </div>
            </div>
            <div class="card-body">
                <div class="bg-custom">
                    <div class="row col-12">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="title">@lang('Title')</label>
                                <p>{{$DdDentalHistory->title }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="description">@lang('Description')</label>
                                <p>{{$DdDentalHistory->description }}</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="status">@lang('Status')</label>
                                <p>
                                    @if($DdDentalHistory->status == 1)
                                        @lang('Active')
                                    @elseif($DentalHistory->status == 0)
                                        @lang('Inactive')
                                    @else
                                        @lang('Unknown')
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
