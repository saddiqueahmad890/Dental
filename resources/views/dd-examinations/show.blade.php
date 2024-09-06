@extends('layouts.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3><a href="{{ route('dd-examinations.index') }}" class="btn btn-outline btn-info"><i class="fas fa-eye"></i> View All</a></h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dd-examinations.index') }}">@lang('Category')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('Category Info')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="card">
        <div class="card-header bg-info">
            <h3 class="card-title">@lang('Category Info')</h3>
            <div class="card-tools">
                <a href="{{ route('dd-examinations.edit', $dd_examination) }}" class="btn btn-info">@lang('Edit')</a>
            </div>
        </div>
        <div class="card-body">
            <div class="bg-custom">
                <div class="row col-12">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="title">@lang('Title')</label>
                            <p>{{ $dd_examination->title }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="description">@lang('Description')</label>
                            <p>{{ $dd_examination->description }}</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="status">@lang('Status')</label>
                            <p>{{ $dd_examination->status == '1' ? 'Active' : 'Inactive' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
