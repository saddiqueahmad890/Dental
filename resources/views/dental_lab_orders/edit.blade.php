@extends('layouts.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1>@lang('Dental Lab Order Information')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dental_lab_orders.index') }}">@lang('Dental Lab Orders')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('Order Information')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Dental Lab Order Information')</h3>
                    <input type="hidden" id="record_id" value="{{ $dentalLabOrder->id }}">
                    <input type="hidden" id="table_name" value="dentalLabOrder">
                </div>
                <div class="card-body">

                    <form id="dentalLabOrderForm" class="form-material form-horizontal bg-custom"
                        action="{{ route('dental_lab_orders.update', $dentalLabOrder) }}" method="POST"
                        enctype="multipart/form-data" data-parsley-validate>
                        @csrf
                        @method('PUT')
                        <section style="font-size: 12px; width: 700px; margin: auto;">
                            <div class="row col-12 m-0 p-0">
                                <div class="row col-12 m-0 mt-5 p-0">
                                    <div class="p-0 px-1 col-12 text-center">
                                        <h4 style="font-style: italic;">INNOVATIVE DENTAL LAB</h4>
                                    </div>
                                </div>
                                @php
                                    $isLaboratorist = Auth::user()->hasRole('laboratorist');
                                @endphp
                                <div class="row col-12 m-0 p-4 mt-4">
                                    <div class="row col-12 m-0 p-0">
                                        <div class="col-6 m-0 p-2 h-100 border border-dark"
                                            style="border-top: none !important; border-left: none !important;">

                                            <!-- Doctor Name -->
                                            <div class="col-12 m-0 my-2 p-0 d-flex">
                                                <span style="font-size: 14px; font-weight: bold; width: auto;">Doctor
                                                    Name:</span>
                                                <div style="width: 69.6%; padding-inline: 15px;">
                                                    <select class="form-control" name="doctor_id"
                                                        {{ $isLaboratorist ? 'disabled' : '' }}>
                                                        <option value="" disabled>Select Doctor</option>
                                                        @foreach ($doctors as $doctor)
                                                            <option value="{{ $doctor->id }}"
                                                                {{ $doctor->id == $dentalLabOrder->doctor_id ? 'selected' : '' }}>
                                                                {{ $doctor->user->name ?? '' }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Patient Name -->
                                            <div class="col-12 m-0 my-2 p-0 d-flex">
                                                <span style="font-size: 14px; font-weight: bold; width: auto;">Patient
                                                    Name:</span>
                                                <div style="width: 73%; padding-inline: 15px;">
                                                    <select class="form-control" name="patient_id"
                                                        {{ $isLaboratorist ? 'disabled' : '' }}>
                                                        <option value="" disabled>Select Patient</option>
                                                        @foreach ($patients as $patient)
                                                            <option value="{{ $patient->id }}"
                                                                {{ $patient->id == $dentalLabOrder->patient_id ? 'selected' : '' }}>
                                                                {{ $patient->user->name ?? ' ' }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 m-0 my-2 p-0 d-flex">
                                                <span style="font-size: 14px; font-weight: bold; width: auto;">Laboratorist
                                                    Name:</span>
                                                <div style="width: 73%; padding-inline: 15px;">
                                                    <select class="form-control" name="lab_id"
                                                        {{ $isLaboratorist ? 'disabled' : '' }}>
                                                        <option value="" disabled>Select lab</option>
                                                        @foreach ($labs as $lab)
                                                            <option value="{{ $lab->id }}"
                                                                {{ $lab->id == $dentalLabOrder->lab_id ? 'selected' : '' }}>
                                                                {{ $lab->name ?? ' ' }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            @if ($isLaboratorist)
                                                <input type="hidden" name="lab_id" value="{{ $dentalLabOrder->lab_id }}">
                                            @endif

                                            <!-- Sending Date -->
                                            <div class="col-12 m-0 my-2 p-0 d-flex">
                                                <span style="font-size: 14px; font-weight: bold; width: auto;">Sending
                                                    Date:</span>
                                                <div style="width: 75%; padding-inline: 15px;">
                                                    <input type="date" name="sending_date"
                                                        {{ $isLaboratorist ? 'disabled' : '' }} class="form-control"
                                                        value="{{ $dentalLabOrder->sending_date }}"
                                                        placeholder="Sending Date.">
                                                </div>
                                            </div>

                                            <!-- Returning Date -->
                                            <div class="col-12 m-0 my-2 p-0 d-flex">
                                                <span style="font-size: 14px; font-weight: bold; width: auto;">Returning
                                                    Date:</span>
                                                <div style="width: 83%; padding-inline: 15px;">
                                                    <input type="date" name="returning_date"
                                                        {{ $isLaboratorist ? 'disabled' : '' }} class="form-control"
                                                        value="{{ $dentalLabOrder->returning_date }}"
                                                        placeholder="Returning Date.">
                                                </div>
                                            </div>

                                            <!-- Time -->
                                            <div class="row col-12 m-0 p-0 mt-3 justify-content-start">
                                                <div class="col-12 m-0 p-0 d-flex">
                                                    <span
                                                        style="font-size: 14px; font-weight: bold; width: auto;">Time:</span>
                                                    <div style="width: 71%; padding-inline: 15px;" class="ml-auto">
                                                        <input type="time" name="time"
                                                            {{ $isLaboratorist ? 'disabled' : '' }} class="form-control"
                                                            value="{{ $dentalLabOrder->time }}" placeholder="Time.">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-6 m-0 p-0 h-100 border border-dark"
                                            style="border-top: none !important; border-right: none !important;">
                                            <div class="m-auto mt-4 text-center align-content-center border border-dark"
                                                style="height: 50px; width: 50px; border-radius: 50%;">
                                                Logo
                                            </div>
                                            <div class="row col-12 m-0 mt-2 p-0">
                                                <div class="p-0 px-1 col-12 text-center">
                                                    <h5 style="font-style: italic; font-weight: bold;">INNOVATIVE DENTAL LAB
                                                    </h5>
                                                </div>
                                            </div>
                                            <div class="col-11 m-auto p-2 my-2  rounded-2"
                                                style="border: 1px solid lavender;">
                                                <p class="p-0 m-0">Flat 5C, Block 3C, PHA Flats Main, Ibn-e-Sina Road,
                                                    G11/3 Islamabad.051-2760564, 0313-5998899
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row col-12 m-0 p-0" style="height: 150px;">
                                        <div class="col-6 d-flex flex-row m-0 p-0 h-100 border border-dark">
                                            <div
                                                style="rotate: -90deg;
                        width: 47%;
                        font-size: 17px;
                        font-weight: bold;
                        border: 1px solid black;
                        position: relative;    
                        height: fit-content;
                        top: 60px;
                        left: -62px;
                        padding: 1px;
                        text-align: center;">
                                                ZIRCONIA</div>
                                            <div class="col-3 my-auto" style="margin-left: -100px;">
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">MONO</p>
                                                    <input style="width: fit-content;" type="checkbox"
                                                        name="zirconia_mono"
                                                        id=""{{ $dentalLabOrder->zirconia_mono == '1' ? 'checked' : '' }}
                                                        {{ $isLaboratorist ? 'disabled' : '' }}>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">LAYERED
                                                    </p>

                                                    <input style="width: fit-content;" type="checkbox"
                                                        name="zirconia_layered" id=""
                                                        {{ $dentalLabOrder->zirconia_layered == '1' ? 'checked' : '' }}
                                                        {{ $isLaboratorist ? 'disabled' : '' }}>
                                                </div>

                                            </div>
                                            <div class="ml-5 my-auto">
                                                <div class="row justify-content-between">
                                                    <p
                                                        style="width:fit-content;margin: 0px; margin-right:5px; font-weight: bold;">
                                                        Non Pre Veneers
                                                    </p>
                                                    <input style="width: fit-content;" type="checkbox"
                                                        current-color="red" name="zirconia_non_pre_veneers"
                                                        id=""{{ $dentalLabOrder->zirconia_non_pre_veneers == '1' ? 'checked' : '' }}
                                                        {{ $isLaboratorist ? 'disabled' : '' }}>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p
                                                        style="width:fit-content;margin: 0px; margin-right:5px; font-weight: bold;">
                                                        Veneers</p>
                                                    <input style="width: fit-content;" type="checkbox"
                                                        current-color="green" name="zirconia_veneers" id=""
                                                        {{ $dentalLabOrder->zirconia_veneers == '1' ? 'checked' : '' }}
                                                        {{ $isLaboratorist ? 'disabled' : '' }}>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p
                                                        style="width:fit-content;margin: 0px; margin-right:5px; font-weight: bold;">
                                                        Crown</p>
                                                    <input style="width: fit-content;" type="checkbox"
                                                        current-color="black" name="zirconia_crown" id=""
                                                        {{ $dentalLabOrder->zirconia_crown == '1' ? 'checked' : '' }}
                                                        {{ $isLaboratorist ? 'disabled' : '' }}>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p
                                                        style="width:fit-content;margin: 0px; margin-right:5px; font-weight: bold;">
                                                        Bridges</p>
                                                    <input style="width: fit-content;" type="checkbox"
                                                        current-color="brown" name="zirconia_bridges" id=""
                                                        {{ $dentalLabOrder->zirconia_bridges == '1' ? 'checked' : '' }}
                                                        {{ $isLaboratorist ? 'disabled' : '' }}>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 m-0 p-0 h-100 border border-dark">
                                            <div class="col-12 p-0 m-0">
                                                <div class="row col-12 m-0 p-0 pt-1">
                                                    <div class="col-3 fw-bold fs-larger">
                                                        Shade
                                                    </div>
                                                    <div class=" row col-8 p-0 m-0 justify-content-around">
                                                        <div class="col-4 m-0 p-0">
                                                            <table class="table table-bordered">


                                                                <tbody>
                                                                    <tr>
                                                                        <td style="width:20px; text-align: center; border: 1px dotted black; border-top: none; border-left: none;"
                                                                            class="p-0">
                                                                            <input type="text" name="shade_main_1"
                                                                                value="{{ old('shade_main_1', $dentalLabOrder->shade_main_1) }}"
                                                                                style="text-align: center; width: 100%;"
                                                                                {{ $isLaboratorist ? 'disabled' : '' }}>
                                                                        </td>
                                                                        <td style="width:20px; text-align: center; border: 1px dotted black; border-top: none;"
                                                                            class="p-0">
                                                                            <input type="text" name="shade_left_1_1"
                                                                                value="{{ old('shade_left_1_1', $dentalLabOrder->shade_left_1_1) }}"
                                                                                style="text-align: center; width: 100%;"
                                                                                {{ $isLaboratorist ? 'disabled' : '' }}>
                                                                        </td>
                                                                        <td style="width:20px; text-align: center; border: 1px dotted black; border-top: none; border-right: none; min-width: 0px;"
                                                                            class="p-0">
                                                                            <input type="text" name="shade_left_1_2"
                                                                                value="{{ old('shade_left_1_2', $dentalLabOrder->shade_left_1_2) }}"
                                                                                style="text-align: center; width: 100%;"
                                                                                {{ $isLaboratorist ? 'disabled' : '' }}>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width:20px; text-align: center; border: 1px dotted black; border-left: none;"
                                                                            class="p-0">
                                                                            D
                                                                        </td>
                                                                        <td style="width:20px; text-align: center; border: 1px dotted black;"
                                                                            class="p-0">
                                                                            <input type="text" name="shade_left_1_3"
                                                                                value="{{ old('shade_left_1_3', $dentalLabOrder->shade_left_1_3) }}"
                                                                                style="text-align: center; width: 100%;"
                                                                                {{ $isLaboratorist ? 'disabled' : '' }}>
                                                                        </td>
                                                                        <td style="width:20px; text-align: center; border: 1px dotted black; border-right: none; min-width: 0px;"
                                                                            class="p-0">
                                                                            <input type="text" name="shade_right_1_1"
                                                                                value="{{ old('shade_right_1_1', $dentalLabOrder->shade_right_1_1) }}"
                                                                                style="text-align: center; width: 100%;"
                                                                                {{ $isLaboratorist ? 'disabled' : '' }}>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width:20px; text-align: center; border: 1px dotted black; border-bottom: none; border-left: none;"
                                                                            class="p-0">
                                                                            <input type="text" name="shade_right_1_2"
                                                                                value="{{ old('shade_right_1_2', $dentalLabOrder->shade_right_1_2) }}"
                                                                                style="text-align: center; width: 100%;"
                                                                                {{ $isLaboratorist ? 'disabled' : '' }}>
                                                                        </td>
                                                                        <td style="width:20px; text-align: center; border: 1px dotted black; border-bottom: none;"
                                                                            class="p-0">
                                                                            <input type="text" name="shade_right_1_3"
                                                                                value="{{ old('shade_right_1_3', $dentalLabOrder->shade_right_1_3) }}"
                                                                                style="text-align: center; width: 100%;"
                                                                                {{ $isLaboratorist ? 'disabled' : '' }}>
                                                                        </td>
                                                                        <td style="width:20px; text-align: center; border: 1px dotted black; border-bottom: none; border-right: none; min-width: 0px;"
                                                                            class="p-0">
                                                                            <input type="text" name="shade_right_2_4"
                                                                                value="{{ old('shade_right_2_4', $dentalLabOrder->shade_right_2_4) }}"
                                                                                style="text-align: center; width: 100%;"
                                                                                {{ $isLaboratorist ? 'disabled' : '' }}>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>

                                                            </table>
                                                        </div>
                                                        <div class="col-4 m-0 p-0">


                                                            <table class="table">
                                                                <tbody>
                                                                    <tr>
                                                                        <td style="width:20px; text-align: center; border: 1px dotted black; border-top: none; border-left: none;"
                                                                            class="p-0">
                                                                            <input type="text" name="shade_main_2"
                                                                                value="{{ old('shade_main_2', $dentalLabOrder->shade_main_2) }}"
                                                                                style="text-align: center; width: 100%;"
                                                                                {{ $isLaboratorist ? 'disabled' : '' }}>
                                                                        </td>
                                                                        <td style="width:20px; text-align: center; border: 1px dotted black; border-top: none;"
                                                                            class="p-0">
                                                                            <input type="text" name="shade_left_2_1"
                                                                                value="{{ old('shade_left_2_1', $dentalLabOrder->shade_left_2_1) }}"
                                                                                style="text-align: center; width: 100%;"
                                                                                {{ $isLaboratorist ? 'disabled' : '' }}>
                                                                        </td>
                                                                        <td style="width:20px; text-align: center; border: 1px dotted black; border-top: none; border-right: none; min-width: 0px;"
                                                                            class="p-0">
                                                                            <input type="text" name="shade_left_2_2"
                                                                                value="{{ old('shade_left_2_2', $dentalLabOrder->shade_left_2_2) }}"
                                                                                style="text-align: center; width: 100%;"
                                                                                {{ $isLaboratorist ? 'disabled' : '' }}>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width:20px; text-align: center; border: 1px dotted black; border-left: none;"
                                                                            class="p-0">
                                                                            D
                                                                        </td>
                                                                        <td style="width:20px; text-align: center; border: 1px dotted black;"
                                                                            class="p-0">
                                                                            <input type="text" name="shade_left_2_3"
                                                                                value="{{ old('shade_left_2_3', $dentalLabOrder->shade_left_2_3) }}"
                                                                                style="text-align: center; width: 100%;"
                                                                                {{ $isLaboratorist ? 'disabled' : '' }}>
                                                                        </td>
                                                                        <td style="width:20px; text-align: center; border: 1px dotted black; border-right: none; min-width: 0px;"
                                                                            class="p-0">
                                                                            M
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width:20px; text-align: center; border: 1px dotted black; border-bottom: none; border-left: none;"
                                                                            class="p-0">
                                                                            <input type="text" name="shade_right_2_1"
                                                                                value="{{ old('shade_right_2_1', $dentalLabOrder->shade_right_2_1) }}"
                                                                                style="text-align: center; width: 100%;"
                                                                                {{ $isLaboratorist ? 'disabled' : '' }}>
                                                                        </td>
                                                                        <td style="width:20px; text-align: center; border: 1px dotted black; border-bottom: none;"
                                                                            class="p-0">
                                                                            <input type="text" name="shade_right_2_2"
                                                                                value="{{ old('shade_right_2_2', $dentalLabOrder->shade_right_2_2) }}"
                                                                                style="text-align: center; width: 100%;"
                                                                                {{ $isLaboratorist ? 'disabled' : '' }}>
                                                                        </td>
                                                                        <td style="width:20px; text-align: center; border: 1px dotted black; border-bottom: none; border-right: none; min-width: 0px;"
                                                                            class="p-0">
                                                                            <input type="text" name="shade_right_2_3"
                                                                                value="{{ old('shade_right_2_3', $dentalLabOrder->shade_right_2_3) }}"
                                                                                style="text-align: center; width: 100%;"
                                                                                {{ $isLaboratorist ? 'disabled' : '' }}>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 m-0 p-0" style="position: relative; bottom:16px;">
                                                    <table class="table table-bordered border-dark">
                                                        <tbody>
                                                            <tr>
                                                                <td class="p-0 text-center" style="width: 33px;">
                                                                    8
                                                                    <input type="checkbox" selected-color=""
                                                                        name="shade_d_top_8" id="shade_d_top_8"
                                                                        style="padding: 0px; margin:0px;"
                                                                        {{ $isLaboratorist ? 'disabled' : '' }}
                                                                        value={{ $dentalLabOrder->shade_d_top_8 }}
                                                                        {{ isset($dentalLabOrder->shade_d_top_8) && $dentalLabOrder->shade_d_top_8 !== '' ? 'checked' : '' }}>
                                                                </td>
                                                                <td class="p-0 text-center" style="width: 33px;">7
                                                                    <input type="checkbox" selected-color=""
                                                                        name="shade_d_top_7" id="shade_d_top_7"
                                                                        style="padding: 0px; margin:0px;"
                                                                        {{ $isLaboratorist ? 'disabled' : '' }}
                                                                        value={{ $dentalLabOrder->shade_d_top_7 }}
                                                                        {{ isset($dentalLabOrder->shade_d_top_7) && $dentalLabOrder->shade_d_top_7 !== '' ? 'checked' : '' }}>

                                                                </td>
                                                                <td class="p-0 text-center" style="width: 33px;">6
                                                                    <input type="checkbox" selected-color=""
                                                                        name="shade_d_top_6" id="shade_d_top_6"
                                                                        style="padding: 0px; margin:0px;"
                                                                        {{ $isLaboratorist ? 'disabled' : '' }}
                                                                        value={{ $dentalLabOrder->shade_d_top_6 }}
                                                                        {{ isset($dentalLabOrder->shade_d_top_6) && $dentalLabOrder->shade_d_top_6 !== '' ? 'checked' : '' }}>


                                                                </td>
                                                                <td class="p-0 text-center" style="width: 33px;">5
                                                                    <input type="checkbox" selected-color=""
                                                                        name="shade_d_top_5" id="shade_d_top_5"
                                                                        {{ $isLaboratorist ? 'disabled' : '' }}
                                                                        value={{ $dentalLabOrder->shade_d_top_5 }}
                                                                        {{ isset($dentalLabOrder->shade_d_top_5) && $dentalLabOrder->shade_d_top_5 !== '' ? 'checked' : '' }}>

                                                                </td>
                                                                <td class="p-0 text-center" style="width: 33px;">4
                                                                    <input type="checkbox" selected-color=""
                                                                        name="shade_d_top_4" id="shade_d_top_4"
                                                                        style="padding: 0px; margin:0px;"
                                                                        {{ $isLaboratorist ? 'disabled' : '' }}
                                                                        value={{ $dentalLabOrder->shade_d_top_4 }}
                                                                        {{ isset($dentalLabOrder->shade_d_top_4) && $dentalLabOrder->shade_d_top_4 !== '' ? 'checked' : '' }}>

                                                                </td>
                                                                <td class="p-0 text-center" style="width: 33px;">3
                                                                    <input type="checkbox" selected-color=""
                                                                        name="shade_d_top_3" id="shade_d_top_3"
                                                                        style="padding: 0px; margin:0px;"
                                                                        {{ $isLaboratorist ? 'disabled' : '' }}
                                                                        value={{ $dentalLabOrder->shade_d_top_3 }}
                                                                        {{ isset($dentalLabOrder->shade_d_top_3) && $dentalLabOrder->shade_d_top_3 !== '' ? 'checked' : '' }}>

                                                                </td>
                                                                <td class="p-0 text-center" style="width: 33px;">2
                                                                    <input type="checkbox" selected-color=""
                                                                        name="shade_d_top_2" id="shade_d_top_2"
                                                                        style="padding: 0px; margin:0px;"
                                                                        {{ $isLaboratorist ? 'disabled' : '' }}
                                                                        value={{ $dentalLabOrder->shade_d_top_2 }}
                                                                        {{ isset($dentalLabOrder->shade_d_top_2) && $dentalLabOrder->shade_d_top_2 !== '' ? 'checked' : '' }}>


                                                                </td>
                                                                <td class="p-0 text-center" style="width: 33px;">1
                                                                    <input type="checkbox" selected-color=""
                                                                        name="shade_d_top_1" id="shade_d_top_1"
                                                                        {{ $isLaboratorist ? 'disabled' : '' }}
                                                                        value={{ $dentalLabOrder->shade_d_top_1 }}
                                                                        {{ isset($dentalLabOrder->shade_d_top_1) && $dentalLabOrder->shade_d_top_1 !== '' ? 'checked' : '' }}>


                                                                </td>
                                                                <td class="p-0 text-center" style="width: 33px;">1
                                                                    <input type="checkbox" selected-color=""
                                                                        name="shade_d_bottom_1" id="shade_d_bottom_1"
                                                                        style="padding: 0px; margin:0px;"
                                                                        {{ $isLaboratorist ? 'disabled' : '' }}
                                                                        value={{ $dentalLabOrder->shade_d_bottom_1 }}
                                                                        {{ isset($dentalLabOrder->shade_d_bottom_1) && $dentalLabOrder->shade_d_bottom_1 !== '' ? 'checked' : '' }}>

                                                                </td>
                                                                <td class="p-0 text-center" style="width: 33px;">2
                                                                    <input type="checkbox" selected-color=""
                                                                        name="shade_d_bottom_2" id="shade_d_bottom_2"
                                                                        style="padding: 0px; margin:0px;"
                                                                        {{ $isLaboratorist ? 'disabled' : '' }}
                                                                        value={{ $dentalLabOrder->shade_d_bottom_2 }}
                                                                        {{ isset($dentalLabOrder->shade_d_bottom_2) && $dentalLabOrder->shade_d_bottom_2 !== '' ? 'checked' : '' }}>

                                                                </td>
                                                                <td class="p-0 text-center" style="width: 33px;">3
                                                                    <input type="checkbox" selected-color=""
                                                                        name="shade_d_bottom_3" id="shade_d_bottom_3"
                                                                        style="padding: 0px; margin:0px;"
                                                                        {{ $isLaboratorist ? 'disabled' : '' }}
                                                                        value={{ $dentalLabOrder->shade_d_bottom_3 }}
                                                                        {{ isset($dentalLabOrder->shade_d_bottom_3) && $dentalLabOrder->shade_d_bottom_3 !== '' ? 'checked' : '' }}>


                                                                </td>
                                                                <td class="p-0 text-center" style="width: 33px;">4
                                                                    <input type="checkbox" selected-color=""
                                                                        name="shade_d_bottom_4" id="shade_d_bottom_4"
                                                                        style="padding: 0px; margin:0px;"
                                                                        {{ $isLaboratorist ? 'disabled' : '' }}
                                                                        value={{ $dentalLabOrder->shade_d_bottom_4 }}
                                                                        {{ isset($dentalLabOrder->shade_d_bottom_4) && $dentalLabOrder->shade_d_bottom_4 !== '' ? 'checked' : '' }}>


                                                                </td>
                                                                <td class="p-0 text-center" style="width: 33px;">5
                                                                    <input type="checkbox" selected-color=""
                                                                        name="shade_d_bottom_5" id="shade_d_bottom_5"
                                                                        style="padding: 0px; margin:0px;"
                                                                        {{ $isLaboratorist ? 'disabled' : '' }}
                                                                        value={{ $dentalLabOrder->shade_d_bottom_5 }}
                                                                        {{ isset($dentalLabOrder->shade_d_bottom_5) && $dentalLabOrder->shade_d_bottom_5 !== '' ? 'checked' : '' }}>


                                                                </td>
                                                                <td class="p-0 text-center" style="width: 33px;">6
                                                                    <input type="checkbox" selected-color=""
                                                                        name="shade_d_bottom_6" id="shade_d_bottom_6"
                                                                        style="padding: 0px; margin:0px;"
                                                                        {{ $isLaboratorist ? 'disabled' : '' }}
                                                                        value={{ $dentalLabOrder->shade_d_bottom_6 }}
                                                                        {{ isset($dentalLabOrder->shade_d_bottom_6) && $dentalLabOrder->shade_d_bottom_6 !== '' ? 'checked' : '' }}>


                                                                </td>
                                                                <td class="p-0 text-center" style="width: 33px;">7
                                                                    <input type="checkbox" selected-color=""
                                                                        name="shade_d_bottom_7" id="shade_d_bottom_7"
                                                                        style="padding: 0px; margin:0px;"
                                                                        {{ $isLaboratorist ? 'disabled' : '' }}
                                                                        value={{ $dentalLabOrder->shade_d_bottom_7 }}
                                                                        {{ isset($dentalLabOrder->shade_d_bottom_7) && $dentalLabOrder->shade_d_bottom_7 !== '' ? 'checked' : '' }}>


                                                                </td>
                                                                <td class="p-0 text-center"
                                                                    style="width: 33px; min-width:0px;">8
                                                                    <input type="checkbox" selected-color=""
                                                                        name="shade_d_bottom_8" id="shade_d_bottom_8"
                                                                        style="padding: 0px; margin:0px;"
                                                                        {{ $isLaboratorist ? 'disabled' : '' }}
                                                                        value={{ $dentalLabOrder->shade_d_bottom_8 }}
                                                                        {{ isset($dentalLabOrder->shade_d_bottom_8) && $dentalLabOrder->shade_d_bottom_8 !== '' ? 'checked' : '' }}>


                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="p-0 text-center" style="width: 33px;">
                                                                    8
                                                                    <input type="checkbox" selected-color=""
                                                                        name="shade_m_top_8" id="shade_m_top_8"
                                                                        style="padding: 0px; margin:0px;"
                                                                        {{ $isLaboratorist ? 'disabled' : '' }}
                                                                        value={{ $dentalLabOrder->shade_m_top_8 }}
                                                                        {{ isset($dentalLabOrder->shade_m_top_8) && $dentalLabOrder->shade_m_top_8 !== '' ? 'checked' : '' }}>
                                                                </td>
                                                                <td class="p-0 text-center" style="width: 33px;">7
                                                                    <input type="checkbox" selected-color=""
                                                                        name="shade_m_top_7" id="shade_m_top_7"
                                                                        style="padding: 0px; margin:0px;"
                                                                        {{ $isLaboratorist ? 'disabled' : '' }}
                                                                        value={{ $dentalLabOrder->shade_m_top_7 }}
                                                                        {{ isset($dentalLabOrder->shade_m_top_7) && $dentalLabOrder->shade_m_top_7 !== '' ? 'checked' : '' }}>

                                                                </td>
                                                                <td class="p-0 text-center" style="width: 33px;">6
                                                                    <input type="checkbox" selected-color=""
                                                                        name="shade_m_top_6" id="shade_m_top_6"
                                                                        style="padding: 0px; margin:0px;"
                                                                        {{ $isLaboratorist ? 'disabled' : '' }}
                                                                        value={{ $dentalLabOrder->shade_m_top_6 }}
                                                                        {{ isset($dentalLabOrder->shade_m_top_6) && $dentalLabOrder->shade_m_top_6 !== '' ? 'checked' : '' }}>

                                                                </td>
                                                                <td class="p-0 text-center" style="width: 33px;">5
                                                                    <input type="checkbox" selected-color=""
                                                                        name="shade_m_top_5" id="shade_m_top_5"
                                                                        style="padding: 0px; margin:0px;"
                                                                        {{ $isLaboratorist ? 'disabled' : '' }}
                                                                        value={{ $dentalLabOrder->shade_m_top_5 }}
                                                                        {{ isset($dentalLabOrder->shade_m_top_5) && $dentalLabOrder->shade_m_top_5 !== '' ? 'checked' : '' }}>

                                                                </td>
                                                                <td class="p-0 text-center" style="width: 33px;">4
                                                                    <input type="checkbox" selected-color=""
                                                                        name="shade_m_top_4" id="shade_m_top_4"
                                                                        style="padding: 0px; margin:0px;"
                                                                        {{ $isLaboratorist ? 'disabled' : '' }}
                                                                        value={{ $dentalLabOrder->shade_m_top_4 }}
                                                                        {{ isset($dentalLabOrder->shade_m_top_4) && $dentalLabOrder->shade_m_top_4 !== '' ? 'checked' : '' }}>

                                                                </td>
                                                                <td class="p-0 text-center" style="width: 33px;">3
                                                                    <input type="checkbox" selected-color=""
                                                                        name="shade_m_top_3" id="shade_m_top_3"
                                                                        style="padding: 0px; margin:0px;"
                                                                        {{ $isLaboratorist ? 'disabled' : '' }}
                                                                        value={{ $dentalLabOrder->shade_m_top_3 }}
                                                                        {{ isset($dentalLabOrder->shade_m_top_3) && $dentalLabOrder->shade_m_top_3 !== '' ? 'checked' : '' }}>
                                                                </td>
                                                                <td class="p-0 text-center" style="width: 33px;">2
                                                                    <input type="checkbox" selected-color=""
                                                                        name="shade_m_top_2" id="shade_m_top_2"
                                                                        style="padding: 0px; margin:0px;"
                                                                        {{ $isLaboratorist ? 'disabled' : '' }}
                                                                        value={{ $dentalLabOrder->shade_m_top_2 }}
                                                                        {{ isset($dentalLabOrder->shade_m_top_2) && $dentalLabOrder->shade_m_top_2 !== '' ? 'checked' : '' }}>

                                                                </td>
                                                                <td class="p-0 text-center" style="width: 33px;">1
                                                                    <input type="checkbox" selected-color=""
                                                                        name="shade_m_top_1" id="shade_m_top_1"
                                                                        style="padding: 0px; margin:0px;"
                                                                        {{ $isLaboratorist ? 'disabled' : '' }}
                                                                        value={{ $dentalLabOrder->shade_m_top_1 }}
                                                                        {{ isset($dentalLabOrder->shade_m_top_1) && $dentalLabOrder->shade_m_top_1 !== '' ? 'checked' : '' }}>

                                                                </td>
                                                                <td class="p-0 text-center" style="width: 33px;">1
                                                                    <input type="checkbox" selected-color=""
                                                                        name="shade_m_bottom_1" id="shade_m_bottom_1"
                                                                        style="padding: 0px; margin:0px;"
                                                                        {{ $isLaboratorist ? 'disabled' : '' }}
                                                                        value={{ $dentalLabOrder->shade_m_bottom_1 }}
                                                                        {{ isset($dentalLabOrder->shade_m_bottom_1) && $dentalLabOrder->shade_m_bottom_1 !== '' ? 'checked' : '' }}>

                                                                </td>
                                                                <td class="p-0 text-center" style="width: 33px;">2
                                                                    <input type="checkbox" selected-color=""
                                                                        name="shade_m_bottom_2" id="shade_m_bottom_2"
                                                                        style="padding: 0px; margin:0px;"
                                                                        {{ $isLaboratorist ? 'disabled' : '' }}
                                                                        value={{ $dentalLabOrder->shade_m_bottom_2 }}
                                                                        {{ isset($dentalLabOrder->shade_m_bottom_2) && $dentalLabOrder->shade_m_bottom_2 !== '' ? 'checked' : '' }}>


                                                                </td>
                                                                <td class="p-0 text-center" style="width: 33px;">3
                                                                    <input type="checkbox" selected-color=""
                                                                        name="shade_m_bottom_3" id="shade_m_bottom_3"
                                                                        style="padding: 0px; margin:0px;"
                                                                        {{ $isLaboratorist ? 'disabled' : '' }}
                                                                        value={{ $dentalLabOrder->shade_m_bottom_3 }}
                                                                        {{ isset($dentalLabOrder->shade_m_bottom_3) && $dentalLabOrder->shade_m_bottom_3 !== '' ? 'checked' : '' }}>


                                                                </td>
                                                                <td class="p-0 text-center" style="width: 33px;">4
                                                                    <input type="checkbox" selected-color=""
                                                                        name="shade_m_bottom_4" id="shade_m_bottom_4"
                                                                        style="padding: 0px; margin:0px;"
                                                                        {{ $isLaboratorist ? 'disabled' : '' }}
                                                                        value={{ $dentalLabOrder->shade_m_bottom_4 }}
                                                                        {{ isset($dentalLabOrder->shade_m_bottom_4) && $dentalLabOrder->shade_m_bottom_4 !== '' ? 'checked' : '' }}>


                                                                </td>
                                                                <td class="p-0 text-center" style="width: 33px;">5
                                                                    <input type="checkbox" selected-color=""
                                                                        name="shade_m_bottom_5" id="shade_m_bottom_5"
                                                                        style="padding: 0px; margin:0px;"
                                                                        {{ $isLaboratorist ? 'disabled' : '' }}
                                                                        value={{ $dentalLabOrder->shade_m_bottom_5 }}
                                                                        {{ isset($dentalLabOrder->shade_m_bottom_5) && $dentalLabOrder->shade_m_bottom_5 !== '' ? 'checked' : '' }}>


                                                                </td>
                                                                <td class="p-0 text-center" style="width: 33px;">6
                                                                    <input type="checkbox" selected-color=""
                                                                        name="shade_m_bottom_6" id="shade_m_bottom_6"
                                                                        style="padding: 0px; margin:0px;"
                                                                        {{ $isLaboratorist ? 'disabled' : '' }}
                                                                        value={{ $dentalLabOrder->shade_m_bottom_6 }}
                                                                        {{ isset($dentalLabOrder->shade_m_bottom_6) && $dentalLabOrder->shade_m_bottom_6 !== '' ? 'checked' : '' }}>


                                                                </td>
                                                                <td class="p-0 text-center" style="width: 33px;">7
                                                                    <input type="checkbox" selected-color=""
                                                                        name="shade_m_bottom_7" id="shade_m_bottom_7"
                                                                        style="padding: 0px; margin:0px;"
                                                                        {{ $isLaboratorist ? 'disabled' : '' }}
                                                                        value={{ $dentalLabOrder->shade_m_bottom_7 }}
                                                                        {{ isset($dentalLabOrder->shade_m_bottom_7) && $dentalLabOrder->shade_m_bottom_7 !== '' ? 'checked' : '' }}>


                                                                </td>
                                                                <td class="p-0 text-center"
                                                                    style="width: 33px; min-width:0px;">8
                                                                    <input type="checkbox" selected-color=""
                                                                        name="shade_m_bottom_8" id="shade_m_bottom_8"
                                                                        style="padding: 0px; margin:0px;"
                                                                        {{ $isLaboratorist ? 'disabled' : '' }}
                                                                        value={{ $dentalLabOrder->shade_m_bottom_8 }}
                                                                        {{ isset($dentalLabOrder->shade_m_bottom_8) && $dentalLabOrder->shade_m_bottom_8 !== '' ? 'checked' : '' }}>

                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row col-12 m-0 p-0" style="height: 100px;">
                                        <div class="col-6 d-flex flex-row m-0 p-0 h-100 border border-dark">
                                            <div
                                                style="rotate: -90deg;
                        width: 31%;
                        font-size: 17px;
                        font-weight: bold;
                        border: 1px solid black;
                        position: relative;    
                        height: fit-content;
                        top: 35px;
                        left: -36px;
                        padding: 1px;
                        text-align: center;">
                                                E-MAX</div>
                                            <div class="col-3 my-auto" style="margin-left: -40px;">
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">MILLED</p>
                                                    <input style="width: fit-content;" type="checkbox"
                                                        name="e_max_milled" id=""
                                                        {{ $dentalLabOrder->e_max_milled == '1' ? 'checked' : '' }}
                                                        {{ $isLaboratorist ? 'disabled' : '' }}>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">PRESSED
                                                    </p>
                                                    <input style="width: fit-content;" type="checkbox"
                                                        name="e_max_pressed" id=""
                                                        {{ $dentalLabOrder->e_max_pressed == '1' ? 'checked' : '' }}
                                                        {{ $isLaboratorist ? 'disabled' : '' }}>
                                                </div>
                                            </div>
                                            <div class="ml-5 my-auto">
                                                <div class="row justify-content-between">
                                                    <p
                                                        style="width:fit-content;margin: 0px; margin-right:5px; font-weight: bold;">
                                                        Non Pre
                                                        Veneers</p>
                                                    <input style="width: fit-content;" type="checkbox"
                                                        current-color="yellow" name="e_max_non_pre_veneers"
                                                        id=""
                                                        {{ $dentalLabOrder->e_max_non_pre_veneers == '1' ? 'checked' : '' }}
                                                        {{ $isLaboratorist ? 'disabled' : '' }}>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p
                                                        style="width:fit-content;margin: 0px; margin-right:5px; font-weight: bold;">
                                                        Veneers</p>
                                                    <input style="width: fit-content;" type="checkbox"
                                                        current-color="purple" name="e_max_veneers"
                                                        id=""{{ $dentalLabOrder->e_max_veneers == '1' ? 'checked' : '' }}
                                                        {{ $isLaboratorist ? 'disabled' : '' }}>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p
                                                        style="width:fit-content;margin: 0px; margin-right:5px; font-weight: bold;">
                                                        Crown</p>
                                                    <input style="width: fit-content;" type="checkbox"
                                                        current-color="orange" name="e_max_crown" id=""
                                                        {{ $dentalLabOrder->e_max_crown == '1' ? 'checked' : '' }}
                                                        {{ $isLaboratorist ? 'disabled' : '' }}>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p
                                                        style="width:fit-content;margin: 0px; margin-right:5px; font-weight: bold;">
                                                        Bridges</p>
                                                    <input style="width: fit-content;" type="checkbox"
                                                        current-color="pink" name="e_max_bridges" id=""
                                                        {{ $dentalLabOrder->e_max_bridges == '1' ? 'checked' : '' }}
                                                        {{ $isLaboratorist ? 'disabled' : '' }}>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 d-flex flex-row m-0 p-0 h-100 border border-dark">
                                            <div
                                                style="rotate: -90deg;
                        width: 31%;
                        font-size: 26px;
                        font-weight: bold;
                        border: 1px solid black;
                        position: relative;    
                        height: fit-content;
                        top: 28px;
                        left: -30px;
                        padding: 1px;
                        text-align: center;">
                                                PEEK</div>
                                            <div class="col-12 m-0 p-0" style="margin-left: -101px !important;">
                                                <div class="col-7 my-auto" style="margin-left:90px;">
                                                    <div class="row justify-content-between">
                                                        <input style="width: fit-content;" type="checkbox"
                                                            name="peek_removable_partial_denture" id=""
                                                            {{ $dentalLabOrder->peek_removable_partial_denture == '1' ? 'checked' : '' }}
                                                            {{ $isLaboratorist ? 'disabled' : '' }}>
                                                        <p
                                                            style="width:fit-content; font-weight: bold; margin: 0px; font-weight: bold;">
                                                            Removable Partial Denture</p>
                                                    </div>
                                                    <div class="row justify-content-between">
                                                        <input style="width: fit-content;" type="checkbox"
                                                            name="peek_fixed_prosthetic_framework" id=""
                                                            {{ $dentalLabOrder->peek_fixed_prosthetic_framework == '1' ? 'checked' : '' }}
                                                            {{ $isLaboratorist ? 'disabled' : '' }}>
                                                        <p
                                                            style="width:fit-content; font-weight: bold; margin: 0px; font-weight: bold;">
                                                            Fixed Prosthetic Framework</p>
                                                    </div>
                                                    <div class="row justify-content-between">
                                                        <input style="width: fit-content;" type="checkbox"
                                                            name="peek_attachment_restorations" id=""
                                                            {{ $dentalLabOrder->peek_attachment_restorations == '1' ? 'checked' : '' }}
                                                            {{ $isLaboratorist ? 'disabled' : '' }}>
                                                        <p
                                                            style="width:fit-content; font-weight: bold; margin: 0px; font-weight: bold;">
                                                            Attachment Restorations</p>
                                                    </div>
                                                </div>
                                                <div class="col-10 row" style="margin-left: 37px;">
                                                    <div class="row col-4 justify-content-between">
                                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">Screw
                                                        </p>
                                                        <input style="width: fit-content;" type="checkbox"
                                                            name="peek_screw" id=""
                                                            {{ $dentalLabOrder->peek_screw == '1' ? 'checked' : '' }}
                                                            {{ $isLaboratorist ? 'disabled' : '' }}>
                                                    </div>
                                                    <div class="row col-4 ml-2 justify-content-between">
                                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">
                                                            Retained
                                                        </p>
                                                        <input style="width: fit-content;" type="checkbox"
                                                            name="peek_retained" id=""
                                                            {{ $dentalLabOrder->peek_retained == '1' ? 'checked' : '' }}
                                                            {{ $isLaboratorist ? 'disabled' : '' }}>
                                                    </div>
                                                    <div class="row col-4 ml-2 justify-content-between">
                                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">
                                                            Implant
                                                        </p>
                                                        <input style="width: fit-content;" type="checkbox"
                                                            name="peek_implant" id=""
                                                            {{ $dentalLabOrder->peek_implant == '1' ? 'checked' : '' }}
                                                            {{ $isLaboratorist ? 'disabled' : '' }}>
                                                    </div>
                                                </div>
                                                <div class="row col-10 justify-content-between"
                                                    style="margin-left: 37px; width: 86.333333%;">
                                                    <div class="row col-5 justify-content-between">
                                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">
                                                            Supported
                                                        </p>
                                                        <input style="width: fit-content;" type="checkbox"
                                                            name="peek_supported" id=""
                                                            {{ $dentalLabOrder->peek_supported == '1' ? 'checked' : '' }}
                                                            {{ $isLaboratorist ? 'disabled' : '' }}>
                                                    </div>
                                                    <div class="row col-7 justify-content-between">
                                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">
                                                            Superstructures</p>
                                                        <input style="width: fit-content;" type="checkbox"
                                                            name="peek_superstructures" id=""
                                                            {{ $dentalLabOrder->peek_superstructures == '1' ? 'checked' : '' }}
                                                            {{ $isLaboratorist ? 'disabled' : '' }}>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row col-12 m-0 p-0" style="height: 114px;">
                                        <div class="col-6 d-flex flex-row m-0 p-0 h-100 border border-dark">
                                            <div
                                                style="rotate: -90deg;
                        width: 35.5%;
                        font-size: 17px;
                        font-weight: bold;
                        border: 1px solid black;
                        position: relative;    
                        height: fit-content;
                        top: 42px;
                        left: -43.5px;
                        padding: 1px;
                        text-align: center;">
                                                PFM</div>
                                            <div class="my-auto" style="margin-left: -60px;">
                                                <div class="row justify-content-between">
                                                    <p
                                                        style="width:fit-content;margin: 0px; margin-right:5px; font-weight: bold;">
                                                        PORCELAIN</p>
                                                    <input style="width: fit-content;" type="checkbox"
                                                        name="pfm_porcelain" id=""
                                                        {{ $dentalLabOrder->pfm_porcelain == '1' ? 'checked' : '' }}
                                                        {{ $isLaboratorist ? 'disabled' : '' }}>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p
                                                        style="width:fit-content;margin: 0px; margin-right:5px; font-weight: bold;">
                                                        NON-PRES</p>
                                                    <input style="width: fit-content;" type="checkbox"
                                                        name="pfm_non_pres" id=""
                                                        {{ $dentalLabOrder->pfm_non_pres == '1' ? 'checked' : '' }}
                                                        {{ $isLaboratorist ? 'disabled' : '' }}>
                                                </div>
                                            </div>
                                            <div class="col-4 ml-5 my-auto">
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">Implant
                                                    </p>
                                                    <input style="width: fit-content;" type="checkbox"
                                                        current-color="cyan" name="pfm_implant" id=""
                                                        {{ $dentalLabOrder->pfm_implant == '1' ? 'checked' : '' }}
                                                        {{ $isLaboratorist ? 'disabled' : '' }}>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">Post &
                                                        Core
                                                    </p>
                                                    <input style="width: fit-content;" type="checkbox"
                                                        current-color="magenta" name="pfm_post_and_core" id=""
                                                        {{ $dentalLabOrder->pfm_post_and_core == '1' ? 'checked' : '' }}
                                                        {{ $isLaboratorist ? 'disabled' : '' }}>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">Crown</p>
                                                    <input style="width: fit-content;" type="checkbox"
                                                        current-color="gray" name="pfm_crown" id=""
                                                        {{ $dentalLabOrder->pfm_crown == '1' ? 'checked' : '' }}
                                                        {{ $isLaboratorist ? 'disabled' : '' }}>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">Bridges
                                                    </p>
                                                    <input style="width: fit-content;" type="checkbox"
                                                        current-color="lima" name="pfm_bridges" id=""
                                                        {{ $dentalLabOrder->pfm_bridges == '1' ? 'checked' : '' }}
                                                        {{ $isLaboratorist ? 'disabled' : '' }}>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 d-flex flex-row m-0 p-0 h-100 border border-dark"
                                            style="flex-wrap: wrap;">
                                            <div
                                                style="rotate: -90deg;
                        width: 35.5%;
                        font-size: 13px;
                        font-weight: bold;
                        border: 1px solid black;
                        position: relative;    
                        height: fit-content;
                        top: 35px;
                        left: -37.5px;
                        padding: 1px;
                        text-align: center;">
                                                REMOVEABLE <br> PROSTHETICS</div>
                                            <div class="my-auto" style="margin-left: -59px; width: 38%;">
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">Diagnostic
                                                        Wax-up</p>
                                                    <input style="width: fit-content;" type="checkbox"
                                                        name="removable_diagnostic_wax_up" id=""
                                                        {{ $dentalLabOrder->removable_diagnostic_wax_up == '1' ? 'checked' : '' }}
                                                        {{ $isLaboratorist ? 'disabled' : '' }}>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">Hybrid
                                                        Denture
                                                    </p>
                                                    <input style="width: fit-content;" type="checkbox"
                                                        name="removable_hybrid_denture" id=""
                                                        {{ $dentalLabOrder->removable_hybrid_denture == '1' ? 'checked' : '' }}
                                                        {{ $isLaboratorist ? 'disabled' : '' }}>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">Tooth
                                                        Addition
                                                    </p>
                                                    <input style="width: fit-content;" type="checkbox"
                                                        name="removable_tooth_addition" id=""
                                                        {{ $dentalLabOrder->removable_tooth_addition == '1' ? 'checked' : '' }}
                                                        {{ $isLaboratorist ? 'disabled' : '' }}>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">Over
                                                        Denture
                                                    </p>
                                                    <input style="width: fit-content;" type="checkbox"
                                                        name="removable_over_denture" id=""
                                                        {{ $dentalLabOrder->removable_over_denture == '1' ? 'checked' : '' }}
                                                        {{ $isLaboratorist ? 'disabled' : '' }}>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">Relining
                                                        hard/soft</p>
                                                    <input style="width: fit-content;" type="checkbox"
                                                        name="removable_relining_hard_soft" id=""
                                                        {{ $dentalLabOrder->removable_relining_hard_soft == '1' ? 'checked' : '' }}
                                                        {{ $isLaboratorist ? 'disabled' : '' }}>
                                                </div>
                                            </div>
                                            <div class="ml-5 my-auto" style="width: 21%;">
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">Flexible
                                                    </p>
                                                    <input style="width: fit-content;" type="checkbox"
                                                        name="removable_flexible" id=""
                                                        {{ $dentalLabOrder->removable_flexible == '1' ? 'checked' : '' }}
                                                        {{ $isLaboratorist ? 'disabled' : '' }}>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">Veneers
                                                    </p>
                                                    <input style="width: fit-content;" type="checkbox"
                                                        name="removable_veneers" id=""
                                                        {{ $dentalLabOrder->removable_veneers == '1' ? 'checked' : '' }}
                                                        {{ $isLaboratorist ? 'disabled' : '' }}>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">Crown</p>
                                                    <input style="width: fit-content;" type="checkbox"
                                                        name="removable_crown" id=""
                                                        {{ $dentalLabOrder->removable_crown == '1' ? 'checked' : '' }}
                                                        {{ $isLaboratorist ? 'disabled' : '' }}>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">Bridges
                                                    </p>
                                                    <input style="width: fit-content;" type="checkbox"
                                                        name="removable_bridges" id=""
                                                        {{ $dentalLabOrder->removable_bridges == '1' ? 'checked' : '' }}
                                                        {{ $isLaboratorist ? 'disabled' : '' }}>
                                                </div>
                                            </div>
                                            <div class="col-10 row" style="margin-left: 37px;">
                                                <div class="row col-4 justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">Screw</p>
                                                    <input style="width: fit-content;" type="checkbox"
                                                        name="removable_screw" id=""
                                                        {{ $dentalLabOrder->removable_screw == '1' ? 'checked' : '' }}
                                                        {{ $isLaboratorist ? 'disabled' : '' }}>
                                                </div>
                                                <div class="row col-4 ml-2 justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">Retained
                                                    </p>
                                                    <input style="width: fit-content;" type="checkbox"
                                                        name="removable_retained" id=""
                                                        {{ $dentalLabOrder->removable_retained == '1' ? 'checked' : '' }}
                                                        {{ $isLaboratorist ? 'disabled' : '' }}>
                                                </div>
                                                <div class="row col-4 ml-2 justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">Implant
                                                    </p>
                                                    <input style="width: fit-content;" type="checkbox"
                                                        name="removable_implant" id=""
                                                        {{ $dentalLabOrder->removable_implant == '1' ? 'checked' : '' }}
                                                        {{ $isLaboratorist ? 'disabled' : '' }}>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row col-12 m-0 p-0" style="height: 114px;">
                                        <div class="col-6 m-0 p-0 h-100 border border-dark">
                                            <div
                                                style="
                    font-size: 17px;
                    font-weight: bold;
                    height: fit-content;
                    padding: 1px;
                    text-align: center;">
                                                ITEMS SENDING</div>
                                            <div class="row col-12 m-0 p-0">
                                                <div style="width: 39%; padding-left: 17px;">
                                                    <div class="row justify-content-between">
                                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">Imp
                                                        </p>
                                                        <input style="width: fit-content;" type="checkbox"
                                                            name="items_imp" id=""
                                                            {{ $dentalLabOrder->items_imp == '1' ? 'checked' : '' }}
                                                            {{ $isLaboratorist ? 'disabled' : '' }}>
                                                    </div>
                                                    <div class="row justify-content-between">
                                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">
                                                            Partial
                                                        </p>
                                                        <input style="width: fit-content;" type="checkbox"
                                                            name="items_partial" id=""
                                                            {{ $dentalLabOrder->items_partial == '1' ? 'checked' : '' }}
                                                            {{ $isLaboratorist ? 'disabled' : '' }}>
                                                    </div>
                                                    <div class="row justify-content-between">
                                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">
                                                            Digital
                                                            Impression</p>
                                                        <input style="width: fit-content;" type="checkbox"
                                                            name="items_digital_impression" id=""
                                                            {{ $dentalLabOrder->items_digital_impression == '1' ? 'checked' : '' }}
                                                            {{ $isLaboratorist ? 'disabled' : '' }}>
                                                    </div>
                                                </div>
                                                <div style="width: 21%; padding-left: 26px;">
                                                    <div class="row justify-content-between">
                                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">Bite
                                                        </p>
                                                        <input style="width: fit-content;" type="checkbox"
                                                            name="items_bite" id="items_bite"
                                                            {{ $dentalLabOrder->items_bite == '1' ? 'checked' : '' }}
                                                            {{ $isLaboratorist ? 'disabled' : '' }}>
                                                    </div>
                                                    <div class="row justify-content-between">
                                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">Photo
                                                        </p>
                                                        <input style="width: fit-content;" type="checkbox"
                                                            name="items_photo" id=""
                                                            {{ $dentalLabOrder->items_photo == '1' ? 'checked' : '' }}
                                                            {{ $isLaboratorist ? 'disabled' : '' }}>
                                                    </div>
                                                    <div class="row justify-content-between">
                                                        <p style="width:fit-content;margin: 0px; font-weight: bold;"></p>
                                                        <!-- <input style="width: fit-content;" type="checkbox" name="" id=""  > -->
                                                    </div>
                                                </div>
                                                <div style="width: 40%; padding-inline: 22px;">
                                                    <div class="row justify-content-between">
                                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">Study
                                                            Models</p>
                                                        <input style="width: fit-content;" type="checkbox"
                                                            name="items_study_models" id=""
                                                            {{ $dentalLabOrder->items_study_models == '1' ? 'checked' : '' }}
                                                            {{ $isLaboratorist ? 'disabled' : '' }}>
                                                    </div>
                                                    <div class="row justify-content-between">
                                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">Shade
                                                            Tab
                                                        </p>
                                                        <input style="width: fit-content;" type="checkbox"
                                                            name="items_shade_tab" id=""
                                                            {{ $dentalLabOrder->items_shade_tab == '1' ? 'checked' : '' }}
                                                            {{ $isLaboratorist ? 'disabled' : '' }}>
                                                    </div>
                                                    <div class="row justify-content-between">
                                                        <input type="text" name="items_furthers" id="items_furthers"
                                                            value="{{ old('items_furthers', $dentalLabOrder->items_furthers) }}"
                                                            style="width:80px; height:25px; font-size: 12px;"
                                                            class="form-control px-0" placeholder="Enter further details"
                                                            {{ $isLaboratorist ? 'disabled' : '' }}>
                                                        <input style="width: fit-content;" type="checkbox"
                                                            name="items_further" id="items_further"
                                                            {{ $dentalLabOrder->items_further == '1' ? 'checked' : '' }}
                                                            {{ $isLaboratorist ? 'disabled' : '' }}>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 d-flex flex-row m-0 p-0 h-100 border border-dark"
                                            style="flex-wrap: wrap;">
                                            <div
                                                style="rotate: -90deg;
                    width: 35.5%;
                    font-size: 13px;
                    font-weight: bold;
                    border: 1px solid black;
                    position: relative;    
                    height: fit-content;
                    top: 35px;
                    left: -37.5px;
                    padding: 1px;
                    text-align: center;">
                                                REMOVEABLE <br> APPLIANCE</div>
                                            <div class="my-auto" style="margin-left: -59px; width: 20%;">
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">Ortho</p>
                                                    <input style="width: fit-content;" type="checkbox"
                                                        name="appliance_ortho" id=""
                                                        {{ $dentalLabOrder->appliance_ortho == '1' ? 'checked' : '' }}
                                                        {{ $isLaboratorist ? 'disabled' : '' }}>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">Retainer
                                                    </p>
                                                    <input style="width: fit-content;" type="checkbox"
                                                        name="appliance_retainer" id=""
                                                        {{ $dentalLabOrder->appliance_retainer == '1' ? 'checked' : '' }}
                                                        {{ $isLaboratorist ? 'disabled' : '' }}>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">Wire</p>
                                                    <input style="width: fit-content;" type="checkbox"
                                                        name="appliance_wire" id=""
                                                        {{ $dentalLabOrder->appliance_wire == '1' ? 'checked' : '' }}
                                                        {{ $isLaboratorist ? 'disabled' : '' }}>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">Hyrax</p>
                                                    <input style="width: fit-content;" type="checkbox"
                                                        name="appliance_hyrax" id=""
                                                        {{ $dentalLabOrder->appliance_hyrax == '1' ? 'checked' : '' }}
                                                        {{ $isLaboratorist ? 'disabled' : '' }}>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">TPA</p>
                                                    <input style="width: fit-content;" type="checkbox"
                                                        name="appliance_tpa" id=""
                                                        {{ $dentalLabOrder->appliance_tpa == '1' ? 'checked' : '' }}
                                                        {{ $isLaboratorist ? 'disabled' : '' }}>
                                                </div>
                                            </div>
                                            <div class="ml-5 my-auto" style="width: 42%;">
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">Night
                                                        Guard
                                                    </p>
                                                    <input style="width: fit-content;" type="checkbox"
                                                        name="appliance_night_guard" id=""
                                                        {{ $dentalLabOrder->appliance_night_guard == '1' ? 'checked' : '' }}
                                                        {{ $isLaboratorist ? 'disabled' : '' }}>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">Occlusal
                                                        Splint</p>
                                                    <input style="width: fit-content;" type="checkbox"
                                                        name="appliance_occlusal_splint" id=""
                                                        {{ $dentalLabOrder->appliance_occlusal_splint == '1' ? 'checked' : '' }}
                                                        {{ $isLaboratorist ? 'disabled' : '' }}>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">Sheet
                                                        Press
                                                        Retainer
                                                    </p>
                                                    <input style="width: fit-content;" type="checkbox"
                                                        name="appliance_sheet_press_retainer" id=""
                                                        {{ $dentalLabOrder->appliance_sheet_press_retainer == '1' ? 'checked' : '' }}
                                                        {{ $isLaboratorist ? 'disabled' : '' }}>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">Obturator
                                                    </p>
                                                    <input style="width: fit-content;" type="checkbox"
                                                        name="appliance_obturator" id=""
                                                        {{ $dentalLabOrder->appliance_obturator == '1' ? 'checked' : '' }}
                                                        {{ $isLaboratorist ? 'disabled' : '' }}>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">Space
                                                        Maintainer</p>
                                                    <input style="width: fit-content;" type="checkbox"
                                                        name="appliance_space_maintainer" id=""
                                                        {{ $dentalLabOrder->appliance_space_maintainer == '1' ? 'checked' : '' }}
                                                        {{ $isLaboratorist ? 'disabled' : '' }}>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $isLaboratorist = Auth::user()->hasRole('laboratorist');
                                @endphp

                                <div class="col-12 m-0 px-4 py-1">
                                    <span style="font-size: 14px; font-weight: bold; width: auto;">Further
                                        Instructions:</span><br>
                                    <textarea placeholder="Other Details" name="further_instructions" id="further_instructions"
                                        style="width: 100%; padding: 10px; margin: 0px; margin-bottom: 10px;" rows="3"
                                        {{ $isLaboratorist ? 'disabled' : '' }}>
        {{ $dentalLabOrder->further_instructions }}
    </textarea>
                                </div>

                                <div class="col-12 m-0 px-4 pt-1 pb-4">
                                    <span style="font-size: 14px; font-weight: bold; width: auto;">Lab Details:</span><br>
                                    <textarea placeholder="Other Details" name="instructions_from_lab" id="instructions_from_lab"
                                        style="width: 100%; padding: 10px; margin: 0px; margin-bottom: 10px;" rows="3">{{ $dentalLabOrder->instructions_from_lab }}</textarea>
                                </div>


                                <div class="row col-12 mt-5 py-3 pl-4 m-0 p-0">
                                    <div class="col-12">
                                        <div class="form-group pt-2">
                                            <input type="submit" value="{{ __('Submit') }}"
                                                class="btn btn-outline btn-info btn-lg">
                                            <a href="#"
                                                class="btn btn-outline btn-warning btn-lg">{{ __('Cancel') }}</a>
                                        </div>
                                    </div>
                                </div>
                    </form>
                </div>

                </section>
                {{-- </div> --}}
            </div>
        </div>
    </div>
    </div>
    <div class="card">
        <div class="card-header bg-info">
            <h3 class="card-title">Upload Documents</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="col-md-12">
                        <input id="document_file" name="document_file[]" type="file" multiple
                            data-allowed-file-extensions="png jpg jpeg pdf" data-max-file-size="2048K" />
                        <p>{{ __('Max Size: 2048kb, Allowed Format: png, jpg, jpeg, pdf') }}</p>
                        <br>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>@lang('File Name')</th>
                                    <th>@lang('Uploaded By')</th>
                                    <th>@lang('Upload Date')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody id="documentFileTableBody" class="fileTableBody"></tbody>
                            <!-- document files will be loaded here via AJAX -->
                            </tbody>
                        </table>
                    </div>
                    @error('document_file')
                        <div class="error ambitious-red">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize a variable to store the current selected color
        let colorSelect = "";

        // Get all the current-color checkboxes
        const currentColorCheckboxes = document.querySelectorAll('input[type="checkbox"][current-color]');
        console.log(currentColorCheckboxes);

        // Get all the selected-color checkboxes
        const selectedColorCheckboxes = document.querySelectorAll('input[selected-color]');

        // Add event listeners to the current-color checkboxes
        currentColorCheckboxes.forEach(currentColorCheckbox => {
            currentColorCheckbox.addEventListener('click', function() {
                // When a current-color checkbox is clicked, store its value in colorSelect
                colorSelect = currentColorCheckbox.getAttribute('current-color');
                console.log("Selected color: ", colorSelect);
            });
        });

        // Add event listeners to the selected-color checkboxes
        selectedColorCheckboxes.forEach(selectedColorCheckbox => {
            selectedColorCheckbox.addEventListener('click', function() {
                console.log("Clicked checkbox value: ", selectedColorCheckbox.value);

                // Check if the checkbox is checked
                if (selectedColorCheckbox.checked) {
                    // Set the 'selected-color' and 'value' attributes to colorSelect if it's not empty
                    if (colorSelect !== "") {
                        selectedColorCheckbox.setAttribute('selected-color', colorSelect);
                        selectedColorCheckbox.setAttribute('value', colorSelect);
                        console.log("Checkbox updated: ", selectedColorCheckbox);
                    }
                } else {
                    // Reset 'selected-color' and set value to '0' when unchecked
                    selectedColorCheckbox.setAttribute('selected-color', '');
                    selectedColorCheckbox.setAttribute('value', '0');
                    console.log("Color cleared: ", selectedColorCheckbox);
                }
            });
        });
    });
</script>
<script>
    var getFilesUrl = "{{ route('get-files', $dentalLabOrder->id) }}";
    var uploadFilesUrl = "{{ route('upload-file') }}";
    var deleteFilesUrl = "{{ route('delete-file') }}";
    var baseUrl = '{{ asset('') }}';
</script>

@push('scripts')
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            // Disable all text inputs initially
            $('input[type="text"]').prop('disabled', true);

            // Enable/disable text inputs based on checkbox state
            $('input[type="checkbox"]').change(function() {
                var inputBox = $(this).siblings('input[type="text"]');

                if ($(this).is(':checked')) {
                    inputBox.prop('disabled', false);
                } else {
                    inputBox.prop('disabled', true);
                }
            });
        });
    </script>
@endpush
