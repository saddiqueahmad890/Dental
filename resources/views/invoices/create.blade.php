 style="padding-bottom: 30px;"@extends('layouts.layout')
<style>
    .err-message ~ .parsley-errors-list{
        width: 41%;
        top: 96px;
    }
    </style>
@push('header')
    @if (old('account_name') || isset($invoice->invoiceItems))
        <meta name="clear-invoice-html" content="clean">
    @endif
    <meta name="invoice-total" content="{{ old('total', $invoice->total ?? 0) }}">
    <meta name="invoice-grand-total" content="{{ old('grand_total', $invoice->grand_total ?? 0) }}">
@endpush

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3>
                    <a href="{{ route('invoices.index') }}" class="btn btn-outline btn-info"><i class="fas fa-eye"></i> @lang('View All')</a>

                </h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('invoices.index') }}">@lang('Invoice')</a></li>
                    <li class="breadcrumb-item active">@lang('Add Invoice')</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info">
                <h3 class="card-title">@lang('Add Invoice')</h3>
            </div>
            <div class="card-body">
                <form class="form-material form-horizontal bg-custom" action="{{ route('invoices.store') }}" method="POST" data-parsley-validate>
                    @csrf
                    <div class="row col-12 p-0 m-0">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                            <div class="form-group">
                                <label for="user_id">@lang('Patient')</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user-injured"></i></span>
                                    </div>
                                    <select name="user_id"
                                        class="form-control select2 @error('user_id') is-invalid @enderror"
                                        required id="user_id" data-parsley-required="true"
                                        data-parsley-required-message="@lang('Please select patient')" {{ isset($patientTreatmentPlan) ? 'disabled' : '' }}>
                                        <option value="Select Patient" disabled
                                            {{ old('user_id', isset($patientTreatmentPlan) ? $patientTreatmentPlan->patient_id : null) == null ? 'selected' : '' }}>
                                            {{ isset($patientTreatmentPlan) ? '' : 'Select Patient' }}
                                        </option>
                                        @foreach ($patients as $patient)
                                            <option value="{{ $patient->id }}"
                                                @if (old('user_id', isset($patientTreatmentPlan) ? $patientTreatmentPlan->patient_id : '') == $patient->id) selected @endif>
                                                {{ $patient->name }}</option>
                                        @endforeach
                                    </select>
                                    @if (isset($patientTreatmentPlan))
                                        <input type="hidden" name="user_id" value="{{ $patientTreatmentPlan->patient_id }}">
                                        <input type="hidden" name="patient_treatment_plan_id" value="{{ $patientTreatmentPlan->id }}">
                                    @endif
                                    @error('user_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                            <div class="form-group">
                                <label for="doctor_id">@lang('Doctor')</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user-md"></i></span>
                                    </div>
                                    <select name="doctor_id"
                                        class="form-control select2 @error('doctor_id') is-invalid @enderror"
                                        required id="doctor_id" data-parsley-required="true"
                                        data-parsley-required-message="@lang('Please select doctor')" {{ isset($patientTreatmentPlan) ? 'disabled' : '' }}>
                                        <option value="Select Doctor" disabled
                                            {{ old('doctor_id', isset($patientTreatmentPlan) ? $patientTreatmentPlan->doctor_id : null) == null ? 'selected' : '' }}>
                                            {{ isset($patientTreatmentPlan) ? '' : 'Select Doctor' }}
                                        </option>
                                        @foreach ($doctors as $doctor)
                                            <option value="{{ $doctor->id }}"
                                                @if (old('doctor_id', isset($patientTreatmentPlan) ? $patientTreatmentPlan->doctor_id : '') == $doctor->id) selected @endif>
                                                {{ $doctor->name }}</option>
                                        @endforeach
                                    </select>
                                    @if (isset($patientTreatmentPlan))
                                        <input type="hidden" name="doctor_id" value="{{ $patientTreatmentPlan->doctor_id }}">
                                    @endif
                                    @error('doctor_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                            <div class="form-group">
                                <label>@lang('Invoice Date') <b class="ambitious-crimson">*</b></label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                    </div>
                                    <input type="text" name="invoice_date" id="invoice_date" class="form-control flatpickr @error('invoice_date') is-invalid @enderror" placeholder="@lang('Invoice Date')" value="{{ old('invoice_date', date('Y-m-d')) }}" required data-parsley-required="true">
                                </div>
                                @error('invoice_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <input type="hidden" id="commission_percentage" name="commission_percentage"
                                        value="{{ old('commission_percentage', isset($percentage) ? $percentage : '') }}"
                                        class="form-control @error('commission_percentage') is-invalid @enderror"
                                        placeholder="@lang('0.0')"
                                        {{ isset($percentage) ? 'readonly' : 'required' }}>
                                    @error('commission_percentage')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="t1" class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="custom-th-width-20">@lang('Procedure Name')<b class="ambitious-crimson">*</b></th>
                                            <th scope="col" class="custom-th-width-25">@lang('Description')</th>
                                            <th scope="col">@lang('Quantity')</th>
                                            <th scope="col" class="custom-th-width-15">@lang('Price')</th>
                                            <th scope="col" class="custom-th-width-15">@lang('Sub Total')</th>
                                            <th scope="col" class="custom-white-space">@lang('Add / Remove')</th>
                                        </tr>
                                    </thead>
                                    <tbody id="invoice-body">
                                        @if (isset($patientTreatmentPlanProcedures))
                                            @foreach ($patientTreatmentPlanProcedures as $planProcedure)
                                                <tr>
                                                    <td style="padding-bottom: 30px;">
                                                        <input type="hidden" name="patient_treatment_plan_procedure_id[]" value="{{ $planProcedure->id }}">
                                                        <input type="hidden" name="account_name[]" value="{{ $accountHeader->name }}">
                                                        <input type="text" name="title[]" class="form-control" value="{{ $planProcedure->procedure->title }}" readonly
                                                        data-parsley-trigger="change"
                                                        data-parsley-required="true"
                                                        data-parsley-required-message="Please enter procedure name">
                                                                                                        </td>
                                                    <td style="padding-bottom: 30px;">
                                                        <textarea name="description[]" class="form-control" rows="1" placeholder="@lang('Description')">{{ $planProcedure->procedure->description }}</textarea>
                                                    </td>
                                                    <td style="padding-bottom: 30px;">
                                                        <input type="number" step="1" name="quantity[]" class="form-control quantity" value="1" placeholder="@lang('Quantity')" required readonly>
                                                    </td>
                                                    <td style="padding-bottom: 30px;">
                                                        <input type="number" step=".01" name="price[]" class="form-control price" value="{{ $planProcedure->procedure->price }}" placeholder="@lang('Price')" readonly>
                                                    </td>
                                                    <td style="padding-bottom: 30px;">
                                                        <input type="number" step=".01" name="sub_total[]" class="form-control sub_total" placeholder="@lang('Sub Total')" readonly>
                                                    </td>
                                                    <td style="padding-bottom: 30px;">
                                                        <button type="button" class="btn btn-info m-add"><i class="fas fa-plus"></i></button>
                                                        <button type="button" class="btn btn-info m-remove"><i class="fas fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        @if (!(isset($patientTreatmentPlanProcedures)))
                                            <tr>
                                                <td style="padding-bottom: 30px;">
                                                    <input type="hidden" name="patient_treatment_plan_procedure_id[]" value="">
                                                    <input type="hidden" name="account_name[]" value="{{ $accountHeader->name }}">
                                                    <input type="text" name="title[]" class="form-control err-message" placeholder="@lang('Title')"
                                                        data-parsley-trigger="change"
                                                        data-parsley-required="true"
                                                        data-parsley-required-message="Please enter procedure name">
                                                </td>
                                                <td style="padding-bottom: 30px;">
                                                    <textarea name="description[]" class="form-control" rows="1" placeholder="@lang('Description')"></textarea>
                                                </td>
                                                <td style="padding-bottom: 30px;">
                                                    <input type="number" step="1" name="quantity[]" class="form-control quantity" value="1" placeholder="@lang('Quantity')" required readonly>
                                                </td>
                                                <td style="padding-bottom: 30px;">
                                                    <input type="number" step=".01" name="price[]" class="form-control err-message price" placeholder="@lang('Price')" required data-parsley-required-message="Please enter price">
                                                </td>
                                                <td style="padding-bottom: 30px;">
                                                    <input type="number" step=".01" name="sub_total[]" class="form-control sub_total" placeholder="@lang('Sub Total')" readonly>
                                                </td>
                                                <td style="padding-bottom: 30px;">
                                                    <button type="button" class="btn btn-info m-add"><i class="fas fa-plus"></i></button>
                                                    <button type="button" class="btn btn-info m-remove"><i class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                    <tbody>
                                        <tr>
                                            <td colspan="3"></td>
                                            <td class="ambitious-right">@lang('Total')</td>
                                            <td>
                                                <input type="number" step=".01" name="total" class="form-control total" value="{{ old('total', '0.00') }}" placeholder="@lang('Total')" readonly>
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td class="text-right">@lang('Discount')</td>
                                            <td class="text-right">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">%</span>
                                                    </div>
                                                    <input type="number" step=".01" name="discount_percentage" value="{{ old('discount_percentage', '0.00') }}" class="form-control discount_percentage" placeholder="%">
                                                </div>
                                            </td>
                                            <td>
                                                <input type="number" step=".01" name="total_discount" class="form-control discount" value="{{ old('total_discount', '0.00') }}" placeholder="@lang('Total Discount')">
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td class="text-right">@lang('Vat')</td>
                                            <td class="text-right">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">%</span>
                                                    </div>
                                                    <input type="number" step=".01" name="vat_percentage" value="{{ old('vat_percentage', '0.00') }}" class="form-control vat_percentage" placeholder="%">
                                                </div>
                                            </td>
                                            <td>
                                                <input type="number" step=".01" name="total_vat" class="form-control vat" value="{{ old('total_vat', '0.00') }}" placeholder="@lang('Total Vat')">
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"></td>
                                            <td class="ambitious-right">@lang('Grand Total')</td>
                                            <td>
                                                <input type="number" step=".01" name="grand_total" class="form-control grand_total" value="{{ old('grand_total', '0.00') }}" placeholder="@lang('Grand Total')" readonly>
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"></td>
                                            <td class="ambitious-right">@lang('Paid')</td>
                                            <td>
                                                <input type="number" step="1" name="paid" class="form-control paid" value="{{ old('paid', '0') }}" placeholder="@lang('Paid')" readonly>
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"></td>
                                            <td class="ambitious-right">@lang('Due')</td>
                                            <td>
                                                <input type="number" step=".01" name="due" class="form-control due" value="{{ old('due') }}" placeholder="@lang('Due')" readonly>
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row col-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 col-form-label"></label>
                                <div class="col-md-8">
                                    <input type="submit" value="{{ __('Submit') }}" class="btn btn-outline btn-info btn-lg"/>
                                    <a href="{{ route('invoices.index') }}" class="btn btn-outline btn-warning btn-lg">{{ __('Cancel') }}</a>
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
    var fetchCommissionUrl = "{{ route('fetch.commission') }}";
 </script>
@endsection
@push('footer')
    <script src="{{ asset('assets/js/custom/invoice.js') }}"></script>
@endpush
