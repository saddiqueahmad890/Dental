@extends('layouts.layout')
<style>
    .error_message ~ .parsley-errors-list{
        top:66%;
    }
</style>
@section('content')
   <section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-md-12 col-form-label"></label>
                    <div class="col-md-12 d-flex align-items-center">
                        <a  href="{{ route('patient-details.index') }}" class="btn btn-outline btn-warning mr-2 btn-lg">
                            @lang('Patient List')
                        </a>
                        <a href="{{ route('consultancey-fees.index') }}" class="btn btn-outline btn-info btn-lg ">
                            {{ __('Consultancey Fee List') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">@lang('Add Consultancy Fee')</li>
                </ol>
            </div>
        </div>
    </div>
</section>


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Add Consultancy Fee')</h3>
                </div>
                <div class="card-body">
                    <form class="bg-custom" action="{{ route('consultancey-fees.store') }}" method="POST" data-parsley-validate>
                        @csrf
                        <div class="col-12 row">
                            <div class="form-group col-md-6">
                                <label for="date">@lang('Consultancy Fee Date') <b class="text-danger">*</b></label>
                                <input type="text" name="date" id="date"
                                       class="form-control @error('date') is-invalid @enderror"
                                       placeholder="@lang('Consultancy Fee Date')"
                                       value="{{ old('date', date('Y-m-d')) }}"
                                       required readonly>
                                @error('date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="user_id">@lang('User ID')</label>
                                <input type="hidden" id="user_id" name="user_id"
                                       value="{{ old('user_id', $patientDetail->id ?? '') }}">

                                @if (empty($patientDetail->id))
                                <div class="form-group">
                                    <select name="user_id" id="user_id"
                                            class="form-control custom-width-100 select2 @error('user_id') is-invalid @enderror"
                                            required data-parsley-required="true">
                                        <option value="">-- @lang('Select') --</option>
                                        @foreach ($patients as $patient)
                                        <option value="{{ $patient->id }}"
                                                @if ($patient->id == old('user_id')) selected @endif>{{ $patient->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                @else
                                <div class="form-group">
                                    <input type="text" id="user_name" name="user_name"
                                           value="{{ old('user_name', $patientDetail->name ?? '') }}" class="form-control"
                                           placeholder="@lang('User Name')" required readonly>
                                    @error('user_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table custom-table">
                                <thead>
                                <tr>
                                    <th>@lang('Description')</th>
                                    <th>@lang('Amount')</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <textarea name="description" class="form-control" rows="1"
                                                  placeholder="@lang('Description')"
                                                  data-parsley-maxlength="255"></textarea>
                                    </td>
                                    <td>
                                        <input type="number" name="amount" class="form-control error_message"
                                               placeholder="@lang('Amount')" required
                                               data-parsley-required="true"
                                               data-parsley-required-message="Please enter an amount."
                                               data-parsley-type="number"
                                               data-parsley-min="0">
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="form-group">
                            <div class="row col-12">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-outline btn-info btn-lg">
                                        {{ __('Submit') }}
                                    </button>
                                    <a href="{{ route('consultancey-fees.index') }}" id="cancelButton"
                                       class="btn btn-outline btn-warning btn-lg">
                                        {{ __('Cancel') }}
                                    </a>

                                    <script>
                                        document.addEventListener("DOMContentLoaded",
                                            function() {
                                                var cancelButton = document.getElementById("cancelButton");
                                                var referrer = document.referrer;
                                                if (referrer) {
                                                    cancelButton.href = referrer;
                                                }
                                            });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
