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
                        <a href="{{ route('dd-medical-history.index') }}">@lang('Medical History')</a>
                    </li>
                    <li class="breadcrumb-item active">@lang('Medical History Information')</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info">
                <h3 class="card-title">@lang('Medical History Information')</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="title">@lang('Title')</label>
                            <p>{{ $DdMedicalHistory->title }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="description">@lang('Description')</label>
                            <p>{{$DdMedicalHistory->description }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="status">@lang('Status')</label>
                            <p>
                                @if($DdMedicalHistory->status == 1)
                                    @lang('Active')
                                @elseif($DdMedicalHistory->status == 0)
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
@endsection
