@extends('layouts.layout')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3>
                    <a href="{{ route('medical-histories.index') }}" class="btn btn-outline btn-info"><i class="fas fa-eye"></i> @lang('View All')</a>

                </h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dd-medical-history.index') }}">@lang('All Options')</a>
                    </li>
                    <li class="breadcrumb-item active">@lang('Add New Option')</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info">
                <h3 class="card-title">@lang('Add New Medical History')</h3>
            </div>
            <div class="container-fluid p-0">
                <form id="medicalhistoryForm" action="{{ route('medical-history.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-xl-6 p-3">
                            <div class="form-group">
                                <label for="patient">@lang('Select Patient')</label>
                                <select class="form-control @error('patient') is-invalid @enderror"
                                        id="patient"
                                        name="patient"
                                        required
                                        data-parsley-required="true"
                                        data-parsley-required-message="Please select a patient"
                                        data-parsley-trigger="focusout">
                                    <option value="">@lang('Select Patient')</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" @if($user->id == old('patient')) selected @endif>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('patient')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="col-xl-6 p-3">
                            <div class="form-group">
                                <label for="doctor">@lang('Select Doctor')</label>
                                <select class="form-control @error('doctor') is-invalid @enderror" id="doctor" name="doctor">
                                    <option value="">@lang('Select Doctor')</option>
                                    @foreach($user1 as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('doctor')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @foreach($medicalhitory as $item)
                        <div class="col-xl-3 p-3">
                            <div class="form-group m-0">
                                <input type="checkbox" id="title_{{ $item->id }}" name="medical_histories[{{ $item->id }}][checked]">
                                <label for="title_{{ $item->id }}">{{ $item->title }}</label>
                                <input type="text" class="form-control" id="details_{{ $item->id }}" name="medical_histories[{{ $item->id }}][comments]">
                                <input type="hidden" value="{{ $item->id }}" name="medical_histories[{{ $item->id }}][title_id]">
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <div class="col-md-8">
                                    <input type="submit" value="{{ __('Submit') }}" class="btn btn-outline btn-info btn-lg"/>
                                    <a href="{{ route('dd-medical-history.index') }}" class="btn btn-outline btn-warning btn-lg">{{ __('Cancel') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('input[type="text"]').prop('disabled', true);

        $('input[type="checkbox"]').change(function() {
            // Get the corresponding input box
            var inputBox = $(this).siblings('input[type="text"]');

            // Check if the checkbox is checked
            if ($(this).is(':checked')) {
                // Disable the input box if checkbox is checked
                inputBox.prop('disabled', false);
            } else {
                // Enable the input box if checkbox is unchecked
                inputBox.prop('disabled', true);
            }
        });
    });
</script>
@endsection
