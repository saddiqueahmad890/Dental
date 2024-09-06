


@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('labs.index') }}">@lang('Lab')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('Lab Info')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="title">@lang('Title')</label>
                    <p>{{ $lab->title }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="description">@lang('Description')</label>
                    <p>{{ $lab->description }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="phone_no">@lang('Phone')</label>
                    <p>{{ $lab->phone_no }}</p>
                </div>
            </div>


            <div class="col-md-3">
                <div class="form-group">
                    <label for="address">@lang('Address')</label>
                    <p>{{ $lab->address }}</p>
                </div>
            </div>

        </div>
    </div>
  
@endsection
