@extends('layouts.layout')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1>@lang('Drugs History Information')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dd-drug-history.index') }}">@lang('Drugs History')</a>
                    </li>
                    <li class="breadcrumb-item active">@lang('Drugs History Information')</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info">
                <h3 class="card-title">@lang('drug History Information')</h3>
                <div class="card-tools">
                <a href="{{ route('dd-drug-history.edit', $DdDrugHistory) }}" class="btn btn-info">@lang('Edit')</a>
            </div>
            </div>
            <div class="card-body">
                <div class="bg-custom">
                    <div class="row col-12">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="title">@lang('Title')</label>
                                <p>{{  $DdDrugHistory->title }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="description">@lang('Description')</label>
                                <p>{{ $DdDrugHistory->description }}</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="status">@lang('Status')</label>
                                <p>
                                    @if( $DdDrugHistory->status == 1)
                                        @lang('Active')
                                    @elseif($DdDrugHistory->status == 0)
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
