@extends('layouts.layout')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>
                    <a href="{{ route('dd-enquirysource.index') }}" class="btn btn-outline btn-info">
                        <i class="fas fa-eye"></i> View Enquiry Sources
                    </a>
                </h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dd-enquirysource.index') }}">Enquiry Source</a>
                    </li>
                    <li class="breadcrumb-item active">Add Enquiry Source</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info">
                <h3 class="card-source_name">Add Enquiry Source</h3>
            </div>
            <div class="card-body">
                <form id="enquirysourcesForm" class="form-material form-horizontal" action="{{ route('dd-enquirysource.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="source_name">Source Name <b class="ambitious-crimson">*</b></label>
                                <input type="text" id="source_name" name="source_name" value="{{ old('source_name') }}" class="form-control @error('source_name') is-invalid @enderror" placeholder="Source Name" required>
                                @error('source_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-8">
                            <input type="submit" value="Submit" class="btn btn-outline btn-info btn-lg" />
                            <a href="{{ route('dd-enquirysource.index') }}" class="btn btn-outline btn-warning btn-lg">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
