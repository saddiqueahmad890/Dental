@extends('layouts.layout')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dd-enquirysource.index') }}">Enquiry Source</a>
                    </li>
                    <li class="breadcrumb-item active">Enquiry Source Info</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="card">
    <div class="card-header bg-info">
        <h3 class="card-title">Enquiry Source Info</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="source_name">Source Name</label>
                    <p>{{ $enquirySource->source_name }}</p>
                </div>
            </div>
            <!-- Add more fields as needed -->
        </div>
    </div>
</div>
@endsection
