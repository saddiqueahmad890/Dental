@extends('layouts.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dd-treatment-plans.index') }}">@lang('Treatment Plan List')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('treatment_plan Info')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="card">
        <div class="card-header bg-info">
            <h3 class="card-title">@lang('Treatment plan Info')</h3>
            <div class="card-tools">
                <a href="{{ route('dd-treatment-plans.edit', $ddTreatmentPlan) }}" class="btn btn-info">@lang('Edit')</a>
            </div>
        </div>
        <div class="card-body">
            <div class="bg-custom">
                <div class="row col-12">
                <div class="col-md-3">
                        <div class="form-group">
                            <label for="title">@lang('Title')</label>
                            <p>{{ $ddTreatmentPlan->title }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="description">@lang('Description')</label>
                            <p>{{$ddTreatmentPlan->description }}</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="status">@lang('Status')</label>
                            <p>{{ $ddTreatmentPlan->status == '1' ? 'Active' : 'Inactive' }}</p>
    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
