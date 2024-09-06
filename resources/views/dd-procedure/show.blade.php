@extends('layouts.layout')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1>@lang('Procedure Category Information')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dd-procedure-categories.index') }}">@lang('Procedure History')</a>
                    </li>
                    <li class="breadcrumb-item active">@lang('Procedure Information')</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info">
                <h3 class="card-title">@lang('Procedure Information')</h3>
                <div class="card-tools">
                <a href="{{ route('dd-procedures.edit',$ddProcedure) }}" class="btn btn-info">@lang('Edit')</a>
            </div>
            </div>
            <div class="card-body">
                <div class="bg-custom">
                    <div class="row col-12">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="title">@lang('Title')</label>
                                <p>{{  $ddProcedure->title }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="description">@lang('Description')</label>
                                <p>{{$ddProcedure->description}}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="extra">@lang('Extra')</label>
                                <p>{{ $ddProcedure->price}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row col-12">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="info1">@lang('SR-No')</label>
                                <p>{{ $ddProcedure->sr_no}}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="info2">@lang('Procedure Category')</label>
                                <p>{{$ddProcedure->ddprocedurecategory->title ??'-'}}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="info3">@lang('Procedure Code')</label>
                                <p>{{ $ddProcedure->procedure_code}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
