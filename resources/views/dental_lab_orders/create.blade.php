@extends('layouts.layout')


@section('content')
    <style>
        .w-4 {
            width: 4%;
        }

        span {
            font-size: 14px;
        }
    </style>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>
                        <a href="{{ route('dental_lab_orders.index') }}" class="btn btn-outline btn-info">
                            <i class="fas fa-list"></i> @lang('View Dental Lab Orders')
                        </a>
                        <span class="pull-right"></span>
                    </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dental_lab_orders.index') }}">@lang('Dental Lab Orders')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('Add Dental Lab Order')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <body class="px-3">
        <section class=" my-5 pb-5" style="font-size: 12px; width: 700px; margin: auto; overflow: hidden;">
            <div class="row col-12 m-0 p-0 pb-5">
                <div class="row col-12 m-0 mt-5 p-0">
                    <div class="p-0 px-1 text-center">
                        <h4 style="font-style: italic;">INNOVATIVE DENTAL LAB</h4>
                    </div>
                </div>
                <form id="dentalLabOrderForm" class="form-material form-horizontal bg-custom"
                    action="{{ route('dental_lab_orders.store') }}" method="POST" enctype="multipart/form-data"
                    data-parsley-validate>
                    @csrf
                    <div class="row col-12 m-0 p-4 mt-4">
                        <div class="row col-12 m-0 p-0">
                            <div class="col-6 m-0 p-2 h-100 border border-dark"
                                style="border-top: none !important; border-left: none !important;">
                                <div class="col-12 m-0 my-2 p-0 d-flex">
                                    <span style="font-size: 14px; font-weight: bold; width: auto;">Doctor Name:</span>
                                    <div style="width: 69.6%; padding-inline: 15px;">
                                        <select class="form-control" name="doctor_id">
                                            <option value="" disabled selected>Select Doctor</option>
                                            @foreach ($doctors as $doctor)
                                                <option value="{{ $doctor->id }}">{{ $doctor->user->name ?? '' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 m-0 my-2 p-0 d-flex">
                                    <span style="font-size: 14px; font-weight: bold; width: auto;">Patient Name:</span>
                                    <div style="width: 73%; padding-inline: 15px;">
                                        <select class="form-control" name="patient_id">
                                            <option value="" disabled selected>Select Patient</option>
                                            @foreach ($patients as $patient)
                                                <option value="{{ $patient->id }}">{{ $patient->user->name ?? ' ' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 m-0 my-2 p-0 d-flex">
                                    <span style="font-size: 14px; font-weight: bold; width: auto;">laboratorist Name:</span>
                                    <div style="width: 73%; padding-inline: 15px;">
                                        <select class="form-control" name="lab_id">
                                            <option value="" disabled selected>Select Laboratoris</option>
                                            @foreach ($labs as $lab)
                                                <option value="{{ $lab->id }}">{{ $lab->name ?? ' ' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- <div class="border-top border-dark row col-12 m-0 p-0"> -->
                                <div class="col-12 m-0 my-2 p-0 d-flex">
                                    <span style="font-size: 14px; font-weight: bold; width: auto;">Sending Date:</span>
                                    <div style="width: 75%; padding-inline: 15px;">
                                        <input type="date" name="sending_date" class="form-control"
                                            placeholder="Sending Date." id="sending_date">
                                    </div>
                                </div>

                                <script>
                                    // JavaScript to set the default date to today
                                    document.addEventListener('DOMContentLoaded', (event) => {
                                        const today = new Date().toISOString().split('T')[0];
                                        document.getElementById('sending_date').value = today;
                                    });
                                </script>

                                <div class=" col-12 m-0 my-2 p-0 d-flex">
                                    <span style="font-size: 14px; font-weight: bold; width: auto;">Returning Date:</span>
                                    <div style=" width: 83%;  padding-inline: 15px;">
                                        <input type="date" name="returning_date" class="form-control"
                                            placeholder="Returning Date.">
                                    </div>
                                </div>
                                <div class="row col-12 m-0 p-0 mt-3 justify-content-start">
                                    <div class=" col-12 m-0 p-0 d-flex">
                                        <span style="font-size: 14px; font-weight: bold; width: auto;">Time:</span>
                                        <div style=" width: 71%;  padding-inline: 15px;" class="ml-auto">
                                            <input type="time" name="time" class="form-control" placeholder="Time.">
                                        </div>
                                    </div>
                                    <!-- </div> -->
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
                                        <h5 style="font-style: italic; font-weight: bold;">INNOVATIVE DENTAL LAB</h5>
                                    </div>
                                </div>
                                <div class="col-11 m-auto p-2 my-2  rounded-2" style="border: 1px solid lavender;">
                                    <p class="p-0 m-0">Flat 5C, Block 3C, PHA Flats Main, Ibn-e-Sina Road,
                                        G11/3 Islamabad.051-2760564, 0313-5998899
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row col-12 m-0 p-0" style="height: 190px;">
                            <div class="col-6 d-flex flex-row m-0 p-0 h-100 border border-dark">
                                <div
                                    style="rotate: -90deg;
                        width: 59%;
                        font-size: 17px;
                        font-weight: bold;
                        border: 1px solid black;
                        position: relative;    
                        height: fit-content;
                        top: 80px;
                        left: -82px;
                        padding: 1px;
                        text-align: center;">
                                    ZIRCONIA</div>
                                <div class="col-3 my-auto" style="margin-left: -140px;">
                                    <div class="row justify-content-between">
                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">MONO</p>
                                        <input style="width: fit-content;" type="checkbox" name="zirconia_mono"
                                            id="zirconia_mono" va>
                                    </div>
                                    <div class="row justify-content-between">
                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">LAYERED</p>
                                        <input style="width: fit-content;" type="checkbox" name="zirconia_layered"
                                            id="zirconia_layered">
                                    </div>
                                </div>
                                <div class="ml-5 my-auto">
                                    <div class="row justify-content-between">
                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">Non Pre Veneers</p>
                                        <input style="width: fit-content;" type="checkbox" current-color="red"
                                            name="zirconia_non_pre_veneers" id="zirconia_non_pre_veneers">
                                    </div>
                                    <div class="row justify-content-between">
                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">Veneers</p>
                                        <input style="width: fit-content;" type="checkbox" current-color="green"
                                            name="zirconia_veneers" id="zirconia_veneers">
                                    </div>
                                    <div class="row justify-content-between">
                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">Crown</p>
                                        <input style="width: fit-content;" type="checkbox" current-color="black"
                                            name="zirconia_crown" id="zirconia_crown">
                                    </div>
                                    <div class="row justify-content-between">
                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">Bridges</p>
                                        <input style="width: fit-content;" type="checkbox" current-color="brown"
                                            name="zirconia_bridges" id="zirconia_bridges">
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
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <td style="width: 30px; height:30px; text-align: center; border: 1px dotted black; border-top: none; border-left: none;"
                                                                class="p-0">
                                                                <input type="text" style="width:30px; font-size: 12px;"
                                                                    class="form-control px-0" placeholder="#A1"
                                                                    id="shade_main_1" name="shade_main_1">
                                                            </td>
                                                            <td style="width: 30px; height:30px; text-align: center; border: 1px dotted black;  border-top: none;"
                                                                class="p-0">
                                                                <input type="text" style="width:30px; font-size: 12px;"
                                                                    class="form-control px-0" placeholder="#A2"
                                                                    id="shade_left_1_1" name="shade_left_1_1">
                                                            </td>
                                                            <td style="width: 30px; height:30px; text-align: center; min-width:30px !important; border: 1px dotted black; border-top: none; border-right: none;"
                                                                class="p-0">
                                                                <input type="text" style="width:30px; font-size: 12px;"
                                                                    class="form-control px-0" placeholder="#A3"
                                                                    id="shade_left_1_2" name="shade_left_1_2">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 30px; height:30px; text-align: center; border: 1px dotted black;  border-left: none;"
                                                                class="p-0 text-center align-content-center">D</td>
                                                            <td style="width: 30px; height:30px; text-align: center; border: 1px dotted black;"
                                                                class="p-0">
                                                                <input type="text" style="width:30px; font-size: 12px;"
                                                                    class="form-control px-0" placeholder="#A4"
                                                                    id="shade_left_1_3" name="shade_left_1_3">

                                                            </td>
                                                            <td style="width: 30px; height:30px; text-align: center; min-width:30px !important; border: 1px dotted black; border-right: none;"
                                                                class="p-0">
                                                                <input type="text" style="width:30px; font-size: 12px;"
                                                                    class="form-control px-0" placeholder="#A5"
                                                                    id="shade_right_1_1" name="shade_right_1_1">

                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 30px; height:30px; text-align: center; border: 1px dotted black; border-bottom: none; border-left: none;"
                                                                class="p-0">
                                                                <input type="text" style="width:30px; font-size: 12px;"
                                                                    class="form-control px-0" placeholder="#A6"
                                                                    id="shade_right_1_2" name="shade_right_1_2">
                                                            </td>
                                                            <td style="width: 30px; height:30px; text-align: center; border: 1px dotted black; border-bottom: none; "
                                                                class="p-0">
                                                                <input type="text" style="width:30px; font-size: 12px;"
                                                                    class="form-control px-0" placeholder="#A7"
                                                                    id="shade_right_1_3" name="shade_right_1_3">
                                                            </td>
                                                            <td style="width: 30px; height:30px; text-align: center; min-width:30px !important; border: 1px dotted black; border-bottom: none; border-right: none;"
                                                                class="p-0">
                                                                <input type="text" style="width:30px; font-size: 12px;"
                                                                    class="form-control px-0" placeholder="#A8"
                                                                    id="shade_right_2_4" name="shade_right_2_4">
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-4 m-0 p-0">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <td style="width: 30px; height:30px; text-align: center; border: 1px dotted black; border-top: none; border-left: none;"
                                                                class="p-0">
                                                                <input type="text" style="width:30px; font-size: 12px;"
                                                                    class="form-control px-0" placeholder="#A1"
                                                                    id="shade_main_2" name="shade_main_2">
                                                            </td>
                                                            <td style="width: 30px; height:30px; text-align: center; border: 1px dotted black;  border-top: none;"
                                                                class="p-0">
                                                                <input type="text" style="width:30px; font-size: 12px;"
                                                                    class="form-control px-0" placeholder="#A1"
                                                                    id="shade_left_2_1" name="shade_left_2_1">
                                                            </td>
                                                            <td style="width: 30px; height:30px; text-align: center;min-width:30px !important; border: 1px dotted black; border-top: none; border-right: none;"
                                                                class="p-0">
                                                                <input type="text" style="width:30px; font-size: 12px;"
                                                                    class="form-control px-0" placeholder="#A1"
                                                                    id="shade_left_2_2" name="shade_left_2_2">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 30px; height:30px; text-align: center; border: 1px dotted black;  border-left: none;"
                                                                class="p-0 text-center align-content-center">M</td>
                                                            <td style="width: 30px; height:30px; text-align: center; border: 1px dotted black;"
                                                                class="p-0">
                                                                <input type="text" style="width:30px; font-size: 12px;"
                                                                    class="form-control px-0" placeholder="#A1"
                                                                    id="shade_left_2_3" name="shade_left_2_3">

                                                            </td>
                                                            <td style="width: 30px; height:30px; text-align: center;min-width:30px !important; border: 1px dotted black; border-right: none;"
                                                                class="p-0 text-center align-content-center">
                                                                D
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 30px; height:30px; text-align: center; border: 1px dotted black; border-bottom: none; border-left: none;"
                                                                class="p-0">
                                                                <input type="text" style="width:30px; font-size: 12px;"
                                                                    class="form-control px-0" placeholder="#A1"
                                                                    id="shade_right_2_1" name="shade_right_2_1">
                                                            </td>
                                                            <td style="width: 30px; height:30px; text-align: center; border: 1px dotted black; border-bottom: none; "
                                                                class="p-0">
                                                                <input type="text" style="width:30px; font-size: 12px;"
                                                                    class="form-control px-0" placeholder="#A1"
                                                                    id="shade_right_2_2" name="shade_right_2_2">
                                                            </td>
                                                            <td style="width: 30px; height:30px; text-align: center;min-width:30px !important; border: 1px dotted black; border-bottom: none; border-right: none;"
                                                                class="p-0">
                                                                <input type="text" style="width:30px; font-size: 12px;"
                                                                    class="form-control px-0" placeholder="#A1"
                                                                    id="shade_right_2_3" name="shade_right_2_3">
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 m-0 p-0" style="position: relative; bottom: 14px;">
                                        <table class="table table-bordered border-dark">
                                            <tbody>
                                                <tr>
                                                    <td class="p-0 text-center" style="width: 33px;">
                                                        8
                                                        <input type="checkbox" name="shade_d_top_8" selected-color=""
                                                            id="shade_d_top_8" style="padding: 0px; margin:0px;">
                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">7
                                                        <input type="checkbox" name="shade_d_top_7" selected-color=""
                                                            id="shade_d_top_7" style="padding: 0px; margin:0px;">

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">6
                                                        <input type="checkbox" name="shade_d_top_6" selected-color=""
                                                            id="shade_d_top_6" style="padding: 0px; margin:0px;">

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">5
                                                        <input type="checkbox" name="shade_d_top_5" selected-color=""
                                                            id="shade_d_top_5" style="padding: 0px; margin:0px;">

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">4
                                                        <input type="checkbox" name="shade_d_top_4" selected-color=""
                                                            id="shade_d_top_4" style="padding: 0px; margin:0px;">

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">3
                                                        <input type="checkbox" name="shade_d_top_3" selected-color=""
                                                            id="shade_d_top_3" style="padding: 0px; margin:0px;">

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">2
                                                        <input type="checkbox" name="shade_d_top_2" selected-color=""
                                                            id="shade_d_top_2" style="padding: 0px; margin:0px;">

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">1
                                                        <input type="checkbox" name="shade_d_top_1" selected-color=""
                                                            id="shade_d_top_1" style="padding: 0px; margin:0px;">

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">1
                                                        <input type="checkbox" name="shade_d_bottom_1" selected-color=""
                                                            id="shade_d_bottom_1" style="padding: 0px; margin:0px;">

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">2
                                                        <input type="checkbox" name="shade_d_bottom_2" selected-color=""
                                                            id="shade_d_bottom_2" style="padding: 0px; margin:0px;">

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">3
                                                        <input type="checkbox" name="shade_d_bottom_3" selected-color=""
                                                            id="shade_d_bottom_3" style="padding: 0px; margin:0px;">

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">4
                                                        <input type="checkbox" name="shade_d_bottom_4" selected-color=""
                                                            id="shade_d_bottom_4" style="padding: 0px; margin:0px;">

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">5
                                                        <input type="checkbox" name="shade_d_bottom_5" selected-color=""
                                                            id="shade_d_bottom_5" style="padding: 0px; margin:0px;">

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">6
                                                        <input type="checkbox" name="shade_d_bottom_6" selected-color=""
                                                            id="shade_d_bottom_6" style="padding: 0px; margin:0px;">

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">7
                                                        <input type="checkbox" name="shade_d_bottom_7" selected-color=""
                                                            id="shade_d_bottom_7" style="padding: 0px; margin:0px;">

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px; min-width:0px;">8
                                                        <input type="checkbox" name="shade_d_bottom_8" selected-color=""
                                                            id="shade_d_bottom_8" style="padding: 0px; margin:0px;">

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="p-0 text-center" style="width: 33px;">
                                                        8
                                                        <input type="checkbox" selected-color="" name="shade_m_top_8" id="shade_m_top_8"
                                                            style="padding: 0px; margin:0px;">
                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">7
                                                        <input type="checkbox" selected-color="" name="shade_m_top_7" id="shade_m_top_7"
                                                            style="padding: 0px; margin:0px;">

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">6
                                                        <input type="checkbox" selected-color="" name="shade_m_top_6" id="shade_m_top_6"
                                                            style="padding: 0px; margin:0px;">

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">5
                                                        <input type="checkbox" selected-color="" name="shade_m_top_5" id="shade_m_top_5"
                                                            style="padding: 0px; margin:0px;">

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">4
                                                        <input type="checkbox" selected-color="" name="shade_m_top_4" id="shade_m_top_4"
                                                            style="padding: 0px; margin:0px;">

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">3
                                                        <input type="checkbox" selected-color="" name="shade_m_top_3" id="shade_m_top_3"
                                                            style="padding: 0px; margin:0px;">

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">2
                                                        <input type="checkbox" selected-color="" name="shade_m_top_2" id="shade_m_top_2"
                                                            style="padding: 0px; margin:0px;">

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">1
                                                        <input type="checkbox" selected-color="" name="shade_m_top_1" id="shade_m_top_1"
                                                            style="padding: 0px; margin:0px;">

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">1
                                                        <input type="checkbox" selected-color="" name="shade_m_bottom_1"
                                                            id="shade_m_bottom_1" style="padding: 0px; margin:0px;">

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">2
                                                        <input type="checkbox" selected-color="" name="shade_m_bottom_2"
                                                            id="shade_m_bottom_2" style="padding: 0px; margin:0px;">

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">3
                                                        <input type="checkbox" selected-color="" name="shade_m_bottom_3"
                                                            id="shade_m_bottom_3" style="padding: 0px; margin:0px;">

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">4
                                                        <input type="checkbox" selected-color="" name="shade_m_bottom_4"
                                                            id="shade_m_bottom_4" style="padding: 0px; margin:0px;">

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">5
                                                        <input type="checkbox" selected-color="" name="shade_m_bottom_5"
                                                            id="shade_m_bottom_5" style="padding: 0px; margin:0px;">

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">6
                                                        <input type="checkbox" selected-color="" name="shade_m_bottom_6"
                                                            id="shade_m_bottom_6" style="padding: 0px; margin:0px;">

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">7
                                                        <input type="checkbox" selected-color="" name="shade_m_bottom_7"
                                                            id="shade_m_bottom_7" style="padding: 0px; margin:0px;">

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px; min-width:0px;">8
                                                        <input type="checkbox" selected-color="" name="shade_m_bottom_8"
                                                            id="shade_m_bottom_8" style="padding: 0px; margin:0px;">

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
                                        <input style="width: fit-content;" type="checkbox" name="e_max_milled"
                                            id="e_max_milled">
                                    </div>
                                    <div class="row justify-content-between">
                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">PRESSED</p>
                                        <input style="width: fit-content;" type="checkbox" name="e_max_pressed"
                                            id="e_max_pressed">
                                    </div>
                                </div>
                                <div class="ml-5 my-auto">
                                    <div class="row justify-content-between">
                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">Non Pre Veneers</p>
                                        <input style="width: fit-content;" type="checkbox" current-color="yellow" name="e_max_non_pre_veneers"
                                            id="e_max_non_pre_veneers">
                                    </div>
                                    <div class="row justify-content-between">
                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">Veneers</p>
                                        <input style="width: fit-content;" type="checkbox" current-color="purple" name="e_max_veneers"
                                            id="e_max_veneers">
                                    </div>
                                    <div class="row justify-content-between">
                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">Crown</p>
                                        <input style="width: fit-content;" type="checkbox" current-color="orange" name="e_max_crown"
                                            id="e_max_crown">
                                    </div>
                                    <div class="row justify-content-between">
                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">Bridges</p>
                                        <input style="width: fit-content;" type="checkbox" current-color="pink" name="e_max_bridges"
                                            id="e_max_bridges">
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
                                                name="peek_removable_partial_denture" id="peek_removable_partial_denture">
                                            <p
                                                style="width:fit-content; font-weight: bold; margin: 0px; font-weight: bold;">
                                                Removable Partial Denture</p>
                                        </div>
                                        <div class="row justify-content-between">
                                            <input style="width: fit-content;" type="checkbox"
                                                name="peek_fixed_prosthetic_framework"
                                                id="peek_fixed_prosthetic_framework">
                                            <p
                                                style="width:fit-content; font-weight: bold; margin: 0px; font-weight: bold;">
                                                Fixed Prosthetic Framework</p>
                                        </div>
                                        <div class="row justify-content-between">
                                            <input style="width: fit-content;" type="checkbox"
                                                name="peek_attachment_restorations" id="peek_attachment_restorations">
                                            <p
                                                style="width:fit-content; font-weight: bold; margin: 0px; font-weight: bold;">
                                                Attachment Restorations</p>
                                        </div>
                                    </div>
                                    <div class="col-10 row" style="margin-left: 37px;">
                                        <div class="row col-4 justify-content-between">
                                            <p style="width:fit-content;margin: 0px; font-weight: bold;">Screw</p>
                                            <input style="width: fit-content;" type="checkbox" name="peek_screw"
                                                id="peek_screw">
                                        </div>
                                        <div class="row col-5 justify-content-between">
                                            <p style="width:fit-content;margin: 0px; font-weight: bold;">Retained</p>
                                            <input style="width: fit-content;" type="checkbox" name="peek_retained"
                                                id="peek_retained">
                                        </div>
                                        <div class="row col-4 justify-content-between">
                                            <p style="width:fit-content;margin: 0px; font-weight: bold;">Implant</p>
                                            <input style="width: fit-content;" type="checkbox" name="peek_implant"
                                                id="peek_implant">
                                        </div>
                                    </div>
                                    <div class="row justify-content-between"
                                        style="margin-left: 45px; width: 71.333333%;">
                                        <div class="row col-6 justify-content-between">
                                            <p style="width:fit-content;margin: 0px; font-weight: bold;">Supported</p>
                                            <input style="width: fit-content;" type="checkbox" name="peek_supported"
                                                id="peek_supported">
                                        </div>
                                        <div class="row col-7 justify-content-between">
                                            <p style="width:fit-content;margin: 0px; font-weight: bold;">Superstructures
                                            </p>
                                            <input style="width: fit-content;" type="checkbox"
                                                name="peek_superstructures" id="peek_superstructures">
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
                                <div class="col-4 my-auto" style="margin-left: -60px;">
                                    <div class="row justify-content-between">
                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">PORCELAIN</p>
                                        <input style="width: fit-content;" type="checkbox" name="pfm_porcelain"
                                            id="pfm_porcelain">
                                    </div>
                                    <div class="row justify-content-between">
                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">NON-PRES</p>
                                        <input style="width: fit-content;" type="checkbox" name="pfm_non_pres"
                                            id="pfm_non_pres">
                                    </div>
                                </div>
                                <div class="col-4 ml-3 my-auto">
                                    <div class="row justify-content-between">
                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">Implant</p>
                                        <input style="width: fit-content;" type="checkbox" current-color="cyan" name="pfm_implant"
                                            id="pfm_implant">
                                    </div>
                                    <div class="row justify-content-between">
                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">Post & Core</p>
                                        <input style="width: fit-content;" type="checkbox" current-color="mangenta" name="pfm_post_and_core"
                                            id="pfm_post_and_core">
                                    </div>
                                    <div class="row justify-content-between">
                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">Crown</p>
                                        <input style="width: fit-content;" type="checkbox" current-color="gray" name="pfm_crown"
                                            id="pfm_crown">
                                    </div>
                                    <div class="row justify-content-between">
                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">Bridges</p>
                                        <input style="width: fit-content;" type="checkbox" current-color="lima" name="pfm_bridges"
                                            id="pfm_bridges">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex flex-row m-0 p-0 h-100 border border-dark" style="flex-wrap: wrap;">
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
                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">Diagnostic Wax-up</p>
                                        <input style="width: fit-content;" type="checkbox"
                                            name="removable_diagnostic_wax_up" id="removable_diagnostic_wax_up">
                                    </div>
                                    <div class="row justify-content-between">
                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">Hybrid Denture</p>
                                        <input style="width: fit-content;" type="checkbox"
                                            name="removable_hybrid_denture" id="removable_hybrid_denture">
                                    </div>
                                    <div class="row justify-content-between">
                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">Tooth Addition</p>
                                        <input style="width: fit-content;" type="checkbox"
                                            name="removable_tooth_addition" id="removable_tooth_addition">
                                    </div>
                                    <div class="row justify-content-between">
                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">Over Denture</p>
                                        <input style="width: fit-content;" type="checkbox" name="removable_over_denture"
                                            id="removable_over_denture">
                                    </div>
                                    <div class="row justify-content-between">
                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">Relining hard/soft</p>
                                        <input style="width: fit-content;" type="checkbox"
                                            name="removable_relining_hard_soft" id="removable_relining_hard_soft">
                                    </div>
                                </div>
                                <div class="ml-5 my-auto" style="width: 21%;">
                                    <div class="row justify-content-between">
                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">Flexible</p>
                                        <input style="width: fit-content;" type="checkbox" name="removable_flexible"
                                            id="removable_flexible">
                                    </div>
                                    <div class="row justify-content-between">
                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">Veneers</p>
                                        <input style="width: fit-content;" type="checkbox" name="removable_veneers"
                                            id="removable_veneers">
                                    </div>
                                    <div class="row justify-content-between">
                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">Crown</p>
                                        <input style="width: fit-content;" type="checkbox" name="removable_crown"
                                            id="removable_crown">
                                    </div>
                                    <div class="row justify-content-between">
                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">Bridges</p>
                                        <input style="width: fit-content;" type="checkbox" name="removable_bridges"
                                            id="removable_bridges">
                                    </div>
                                </div>
                                <div class="col-10 row" style="margin-left: 37px;">
                                    <div class="row col-4 justify-content-between">
                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">Screw</p>
                                        <input style="width: fit-content;" type="checkbox" name="removable_screw"
                                            id="removable_screw">
                                    </div>
                                    <div class="row col-5 ml-1 justify-content-between">
                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">Retained</p>
                                        <input style="width: fit-content;" type="checkbox" name="removable_retained"
                                            id="removable_retained">
                                    </div>
                                    <div class="row col-4 ml-1 justify-content-between">
                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">Implant</p>
                                        <input style="width: fit-content;" type="checkbox" name="removable_implant"
                                            id="removable_implant">
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
                                    <div style="width: 38%; padding-left: 12px;">
                                        <div class="row justify-content-between">
                                            <p style="width:fit-content;margin: 0px; font-weight: bold;">Imp</p>
                                            <input style="width: fit-content;" type="checkbox" name="items_imp"
                                                id="items_imp">
                                        </div>
                                        <div class="row justify-content-between">
                                            <p style="width:fit-content;margin: 0px; font-weight: bold;">Partial</p>
                                            <input style="width: fit-content;" type="checkbox" name="items_partial"
                                                id="items_partial">
                                        </div>
                                        <div class="row justify-content-between">
                                            <p style="width:fit-content;margin: 0px; font-weight: bold;">Digital
                                                Impression</p>
                                            <input style="width: fit-content;" type="checkbox"
                                                name="items_digital_impression" id="items_digital_impression">
                                        </div>
                                    </div>
                                    <div style="width: 20%; padding-left: 26px;">
                                        <div class="row justify-content-between">
                                            <p style="width:fit-content;margin: 0px; font-weight: bold;">Bite</p>
                                            <input style="width: fit-content;" type="checkbox" name="items_bite"
                                                id="items_bite">
                                        </div>
                                        <div class="row justify-content-between">
                                            <p style="width:fit-content;margin: 0px; font-weight: bold;">Photo</p>
                                            <input style="width: fit-content;" type="checkbox" name="items_photo"
                                                id="items_photo">
                                        </div>
                                    </div>
                                    <div style="width: 35%; padding-left: 28px;">
                                        <div class="row justify-content-between">
                                            <p style="width:fit-content;margin: 0px; font-weight: bold;">Study Models</p>
                                            <input style="width: fit-content;" type="checkbox" name="items_study_models"
                                                id="items_study_models">
                                        </div>
                                        <div class="row justify-content-between">
                                            <p style="width:fit-content;margin: 0px; font-weight: bold;">Shade Tab</p>
                                            <input style="width: fit-content;" type="checkbox" name="items_shade_tab"
                                                id="items_shade_tab">
                                        </div>
                                        <div class="row justify-content-between">
                                            <p style="width:fit-content;margin: 0px; font-weight: bold;"></p>
                                            <input type="text" style="width:80px; height:25px; font-size: 12px;"
                                                class="form-control px-0" name="items_furthers">
                                            <input style="width: fit-content;" type="checkbox" name="items_further"
                                                id="items_further">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex flex-row m-0 p-0 h-100 border border-dark" style="flex-wrap: wrap;">
                                <div
                                    style="rotate: -90deg;
                        width: 35%;
                        font-size: 13px;
                        font-weight: bold;
                        border: 1px solid black;
                        position: relative;    
                        height: fit-content;
                        top: 34px;
                        left: -36.5px;
                        padding: 1px;
                        text-align: center;">
                                    REMOVEABLE <br> APPLIANCE</div>
                                <div class="my-auto" style="margin-left: -59px; width: 20%;">
                                    <div class="row justify-content-between">
                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">Ortho</p>
                                        <input style="width: fit-content;" type="checkbox" name="appliance_ortho"
                                            id="appliance_ortho">
                                    </div>
                                    <div class="row justify-content-between">
                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">Retainer</p>
                                        <input style="width: fit-content;" type="checkbox" name="appliance_retainer"
                                            id="appliance_retainer">
                                    </div>
                                    <div class="row justify-content-between">
                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">Wire</p>
                                        <input style="width: fit-content;" type="checkbox" name="appliance_wire"
                                            id="appliance_wire">
                                    </div>
                                    <div class="row justify-content-between">
                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">Hyrax</p>
                                        <input style="width: fit-content;" type="checkbox" name="appliance_hyrax"
                                            id="appliance_hyrax">
                                    </div>
                                    <div class="row justify-content-between">
                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">TPA</p>
                                        <input style="width: fit-content;" type="checkbox" name="appliance_tpa"
                                            id="appliance_tpa">
                                    </div>
                                </div>
                                <div class="ml-5 my-auto" style="width: 42%;">
                                    <div class="row justify-content-between">
                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">Night Guard</p>
                                        <input style="width: fit-content;" type="checkbox" name="appliance_night_guard"
                                            id="appliance_night_guard">
                                    </div>
                                    <div class="row justify-content-between">
                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">Occlusal Splint</p>
                                        <input style="width: fit-content;" type="checkbox"
                                            name="appliance_occlusal_splint" id="appliance_occlusal_splint">
                                    </div>
                                    <div class="row justify-content-between">
                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">Sheet Press Retainer
                                        </p>
                                        <input style="width: fit-content;" type="checkbox"
                                            name="appliance_sheet_press_retainer" id="appliance_sheet_press_retainer">
                                    </div>
                                    <div class="row justify-content-between">
                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">Obturator</p>
                                        <input style="width: fit-content;" type="checkbox" name="appliance_obturator"
                                            id="appliance_obturator">
                                    </div>
                                    <div class="row justify-content-between">
                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">Space Maintainer</p>
                                        <input style="width: fit-content;" type="checkbox"
                                            name="appliance_space_maintainer" id="appliance_space_maintainer">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 m-0 px-4 py-1">
                        <span style="font-size: 14px; font-weight: bold;">Further Instructions:</span><br>
                        <div style="width: 100%; padding-inline: 15px;">
                            <textarea placeholder="Other Details" name="further_instructions" id="further_instructions"
                                style="width: 100%; padding: 10px; margin: 0; margin-bottom: 10px;" rows="3">
        </textarea>
                        </div>
                    </div>

                    <div class="col-12 m-0 px-4 py-1">
                        <span style="font-size: 14px; font-weight: bold;">Lab Details:</span><br>
                        <div style="width: 100%; padding-inline: 15px;">
                            <textarea placeholder="Other Details" name="instructions_from_lab" id="instructions_from_lab"
                                style="width: 100%; padding: 10px; margin: 0; margin-bottom: 10px;" rows="3">
        </textarea>
                        </div>
                    </div>


                    <div class="row col-12 mt-5 py-3 pl-4 m-0 p-0">
                        <div class="col-12">
                            <div class="form-group pt-2">
                                <input type="submit" value="{{ __('Submit') }}"
                                    class="btn btn-outline btn-info btn-lg">
                                <a href="#" class="btn btn-outline btn-warning btn-lg">{{ __('Cancel') }}</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </body>
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

    // Disable all selected-color checkboxes initially
    selectedColorCheckboxes.forEach(selectedColorCheckbox => {
        selectedColorCheckbox.disabled = true;
    });

    // Add event listeners to the current-color checkboxes
    currentColorCheckboxes.forEach(currentColorCheckbox => {
        currentColorCheckbox.addEventListener('click', function() {
            // When a current-color checkbox is clicked, store its value in colorSelect
            colorSelect = currentColorCheckbox.getAttribute('current-color');
            console.log(colorSelect);

            // Enable all selected-color checkboxes if a current-color is selected
            if (colorSelect !== "") {
                selectedColorCheckboxes.forEach(selectedColorCheckbox => {
                    selectedColorCheckbox.disabled = false;
                });
            } else {
                // If no current-color is selected, disable the selected-color checkboxes
                selectedColorCheckboxes.forEach(selectedColorCheckbox => {
                    selectedColorCheckbox.disabled = true;
                });
            }
        });
    });

    // Add event listeners to the selected-color checkboxes
    selectedColorCheckboxes.forEach(selectedColorCheckbox => {
        selectedColorCheckbox.addEventListener('click', function() {
            console.log(selectedColorCheckbox.value);
            // Check if the checkbox is checked
            if (selectedColorCheckbox.checked) {
                // When a selected-color checkbox is clicked and checked, set its 'selected-color' attribute to colorSelect
                if (colorSelect !== "") {
                    selectedColorCheckbox.setAttribute('selected-color', colorSelect);
                    selectedColorCheckbox.setAttribute('value', colorSelect);
                    console.log(selectedColorCheckbox);
                }
            } else {
                // When the checkbox is unchecked, reset its 'selected-color' attribute
                selectedColorCheckbox.setAttribute('selected-color', '');
                selectedColorCheckbox.setAttribute('value', '0');
                console.log('Color cleared:', selectedColorCheckbox);
            }
        });
    });
});
</script>

