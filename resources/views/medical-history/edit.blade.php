@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dd-medical-history.index') }}">@lang('All Options')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('Edit Medical History')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Edit Medical History')</h3>
                </div>
                <div class="container-fluid p-0">
                    <form id="medicalhistoryForm"
                        action="{{ route('medical-history.update', ['doctor_id' => $doctor->id, 'patient_id' => $patient->id]) }}"
                        method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-xl-6 p-3">
                                <div class="form-group">
                                    <label for="patient">@lang('Select Patient')</label>
                                    <select class="form-control" id="patient" name="patient">
                                        @foreach ($patients as $pat)
                                            <option value="{{ $pat->id }}"
                                                {{ $patient->id == $pat->id ? 'selected' : '' }}>
                                                {{ $pat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-6 p-3">
                                <div class="form-group">
                                    <label for="doctor">@lang('Select Doctor')</label>
                                    <select class="form-control select2" id="doctor" name="doctor">
                                        @foreach ($doctors as $doc)
                                            <option value="{{ $doc->id }}"
                                                {{ $doctor->id == $doc->id ? 'selected' : '' }}>
                                                {{ $doc->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @foreach ($medicalhitory as $item)
                                <div class="col-xl-3 p-3">
                                    <div class="form-group m-0">
                                        <input type="checkbox" id="title_{{ $item->id }}"
                                            name="medical_histories[{{ $item->id }}][checked]"
                                            {{ isset($medicalHistories[$item->id]) ? 'checked' : '' }}>
                                        <label for="title_{{ $item->id }}">{{ $item->title }}</label>
                                        <input type="text" class="form-control" id="details_{{ $item->id }}"
                                            name="medical_histories[{{ $item->id }}][comments]"
                                            value="{{ isset($medicalHistories[$item->id]) ? $medicalHistories[$item->id]['comments'] : '' }}">
                                        <input type="hidden"
                                            value="{{ isset($medicalHistories[$item->id]) ? $medicalHistories[$item->id]['id'] : '' }}"
                                            name="medical_histories[{{ $item->id }}][id]">
                                        <input type="hidden" value="{{ $item->id }}"
                                            name="medical_histories[{{ $item->id }}][title_id]">
                                    </div>
                                </div>
                            @endforeach

                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="form-group">
                                    <div class="col-md-8">
                                        <input type="submit" value="{{ __('Update') }}"
                                            class="btn btn-outline btn-info btn-lg" />
                                        <a href="{{ route('medical-history.index') }}"
                                            class="btn btn-outline btn-warning btn-lg">{{ __('Cancel') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Initialize the disabled state based on checkbox status
            $('input[type="checkbox"]').each(function() {
                var inputField = $(this).closest('.form-group').find('input[type="text"]');
                if (!$(this).is(':checked')) {
                    inputField.prop('disabled', true);
                }
            });

            // Update disabled state when checkboxes are clicked
            $('input[type="checkbox"]').change(function() {
                var inputField = $(this).closest('.form-group').find('input[type="text"]');
                inputField.prop('disabled', !$(this).is(':checked'));
            });
        });
    </script>
@endsection
