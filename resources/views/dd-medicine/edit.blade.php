@extends('layouts.layout')
@section('one_page_css')
    <link href="{{ asset('assets/css/quill.snow.css') }}" rel="stylesheet">
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6 d-flex">
                    <h3 class="mr-2"><a href="{{ route('dd-medicine.create') }}" class="btn btn-outline btn-info">+
                            @lang('Add New Medicine')</a></h3>
                    <h3>
                        <a href="{{ route('dd-medicine.index') }}" class="btn btn-outline btn-info">
                            <i class="fas fa-eye"></i> @lang('View All')
                        </a>
                        <span class="pull-right"></span>
                    </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dd-medicine.index') }}">@lang('All Medicines')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('Edit Medicine')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">Edit Medicine ({{ $dd_medicine->name }})</h3>
                </div>
                <div class="card-body">

                    <form id="medicineForm" class="form-material form-horizontal bg-custom"
                        action="{{ route('dd-medicine.update', $dd_medicine->id) }}" method="POST"
                        enctype="multipart/form-data" data-parsley-validate>
                        @csrf
                        @method('PUT')
                        <div class="row col-12 m-0 p-0">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">@lang('Name') <b class="ambitious-crimson">*</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                        </div>
                                        <input type="text" id="name" name="name"
                                            value="{{ old('name', $dd_medicine->name) }}"
                                            class="form-control @error('name') is-invalid @enderror"
                                            placeholder="@lang('Name')" required data-parsley-required="true"
                                            data-parsley-required-message="Please enter medicine name."
                                            data-parsley-trigger="change">
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="description">@lang('Description') <b class="ambitious-crimson">*</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                        </div>
                                        <input type="text" id="description" name="description"
                                            value="{{ old('description', $dd_medicine->description) }}"
                                            class="form-control @error('description') is-invalid @enderror"
                                            placeholder="@lang('Description')" required data-parsley-required="true"
                                            data-parsley-required-message="Please enter medicine Description."
                                            data-parsley-trigger="change">
                                        @error('description')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="dd_medicine_type">@lang('Medicine Type') <b
                                            class="ambitious-crimson">*</b></label>
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-pills"></i></span>
                                        </div>
                                        <select id="dd_medicine_type" name="dd_medicine_type"
                                            class="form-control @error('dd_medicine_type') is-invalid @enderror" required
                                            data-parsley-required="true"
                                            data-parsley-required-message="Please select medicine type." data-parsley-trigger="change">
                                            <option value="">@lang('Select Medicine Type')</option>
                                            @foreach ($ddMedicineTypes as $type)
                                                <option value="{{ $type->id }}"
                                                    {{ old('dd_medicine_type', $dd_medicine->dd_medicine_type) == $type->id ? 'selected' : '' }}>
                                                    {{ ucfirst($type->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('dd_medicine_type')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status">@lang('Status') <b class="text-danger">*</b></label>
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-bell"></i></span>
                                        </div>
                                        <select id="status" name="status"
                                            class="form-control @error('status') is-invalid @enderror" required
                                            data-parsley-required="true" data-parsley-trigger="change">
                                            <option value="1"
                                                {{ old('status', $dd_medicine->status) == '1' ? 'selected' : '' }}>
                                                @lang('Active')</option>
                                            <option value="0"
                                                {{ old('status', $dd_medicine->status) == '0' ? 'selected' : '' }}>
                                                @lang('Inactive')</option>
                                        </select>
                                    </div>
                                    @error('status')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row col-12 m-0 p-0">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 col-form-label"></label>
                                    <div class="col-md-8">
                                        <input type="submit" value="@lang('Update')"
                                            class="btn btn-outline btn-info btn-lg" />
                                        <a href="{{ route('dd-medicine.index') }}"
                                            class="btn btn-outline btn-warning btn-lg">@lang('Cancel')</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- start loglist --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Logs List')</h3>
                </div>
                <div class="card-body scroller1">
                    <table class="table table-striped" id="laravel_datatable">
                        <thead>
                            <tr>
                                <th>@lang('Table Name')</th>
                                <th>@lang('Action')</th>
                                <th>@lang('Field Name')</th>
                                <th>@lang('Old value')</th>
                                <th>@lang('New Value')</th>


                                <th>@lang('User Name')</th>
                                <th>@lang('Changed on date')</th>


                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($logs as $log)
                                <tr>

                                    <td>{{ $log->table_name }}</td>
                                    <td>{{ $log->action }}</td>
                                    <td>{{ $log->field_name }}</td>
                                    <td>{{ $log->old_value }}</td>
                                    <td>{{ $log->new_value }}</td>
                                    <td>{{ $log->user->name }}</td>
                                    <td>{{ $log->created_at }}</td>

                                </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- end of loglist --}}
@endsection
@push('footer')
    <script src="{{ asset('assets/js/quill.js') }}"></script>
@endpush
