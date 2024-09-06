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
                    <div class="card-tools">
                        <button id="generatePrint" class="btn btn-default ml-auto"><i class="fas fa-print"></i>
                            Print</button>
                    </div>
                </div>
                <div class="card-body">

                    <div id="print-section" style="display">

                        <section style="font-size: 12px; width: 700px; margin: auto;">
                            <div class="row col-12 m-0 p-0">
                                <div class="row col-12 m-0 mt-5 p-0">
                                    <div class="p-0 px-1 col-12 text-center">
                                        <h4 style="font-style: italic;">INNOVATIVE DENTAL LAB</h4>
                                    </div>
                                </div>
                                <div class="row col-12 m-0 p-4 mt-4">
                                    <div class="row col-12 m-0 p-0">
                                        <div class="col-6 m-0 p-2 h-100 border border-dark"
                                            style="border-top: none !important; border-left: none !important;">
                                            <div class=" col-12 m-0 my-2 p-0 d-flex">
                                                <span style="font-size: 14px; font-weight: bold; width: auto;">Dr:</span>
                                                <div
                                                    style=" width: 92.6%; border-bottom: 1px solid black;padding-top: 2px; padding-inline: 15px;">
                                                    {{ $dentalLabOrder->doctor->user->name }}
                                                </div>
                                            </div>
                                            <div class=" col-12 m-0 my-2 p-0 d-flex">
                                                <span style="font-size: 14px; font-weight: bold; width: auto;">Patient
                                                    Name:</span>
                                                <div
                                                    style=" width: 69%; border-bottom: 1px solid black;padding-top: 2px; padding-inline: 15px;">
                                                    {{ $dentalLabOrder->patient->user->name }}
                                                </div>
                                            </div>
                                            <div class=" col-12 m-0 my-2 p-0 d-flex">
                                                <span style="font-size: 14px; font-weight: bold; width: auto;">Lab
                                                    Name:</span>
                                                <div
                                                    style=" width: 76%; border-bottom: 1px solid black;padding-top: 2px; padding-inline: 15px;">
                                                 {{ $laboratorist_name }}
                                                </div>
                                            </div>
                                            <!-- <div class="border-top border-dark row col-12 m-0 p-0"> -->
                                            <div class=" col-12 m-0 my-2 p-0 d-flex">
                                                <span style="font-size: 14px; font-weight: bold; width: auto;">Sending
                                                    Date:</span>
                                                <div
                                                    style=" width: 69%; border-bottom: 1px solid black;padding-top: 2px; padding-inline: 15px;">
                                                    {{ $dentalLabOrder->sending_date }}
                                                </div>
                                            </div>
                                            <div class=" col-12 m-0 my-2 p-0 d-flex">
                                                <span style="font-size: 14px; font-weight: bold; width: auto;">Returning
                                                    Date:</span>
                                                <div
                                                    style=" width: 66%; border-bottom: 1px solid black;padding-top: 2px; padding-inline: 15px;">
                                                    {{ $dentalLabOrder->returning_date }}
                                                </div>
                                            </div>
                                            <div class="row col-12 m-0 p-0 mt-3 justify-content-start">
                                                <div class=" col-12 m-0 p-0 d-flex">
                                                    <span
                                                        style="font-size: 14px; font-weight: bold; width: auto;">Time:</span>
                                                    <div
                                                        style=" width: 89%; border-bottom: 1px solid black;padding-top: 2px; padding-inline: 15px;">
                                                        {{ $dentalLabOrder->time }}
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
                                                    <input style="width: fit-content;" type="checkbox" name=""
                                                        id=""{{ $dentalLabOrder->zirconia_mono == '1' ? 'checked' : '' }}  disabled>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">LAYERED</p>
                                                   
                                                    <input style="width: fit-content;" type="checkbox" name="" id="" {{ $dentalLabOrder->zirconia_layered == '1' ? 'checked' : '' }}  disabled>
                                                </div>

                                            </div>
                                            <div class="ml-5 my-auto">
                                                <div class="row justify-content-between">
                                                    <p
                                                        style="width:fit-content;margin: 0px; margin-right:5px; font-weight: bold;">
                                                        Non Pre Veneers
                                                    </p>
                                                    <input style="width: fit-content;" current-color="red" type="checkbox" name=""
                                                        id=""{{ $dentalLabOrder->zirconia_non_pre_veneers == '1' ? 'checked' : '' }}  disabled>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p
                                                        style="width:fit-content;margin: 0px; margin-right:5px; font-weight: bold;">
                                                        Veneers</p>
                                                    <input style="width: fit-content;" current-color="green" type="checkbox" name=""
                                                        id="" {{ $dentalLabOrder->zirconia_veneers == '1' ? 'checked' : '' }}  disabled>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p
                                                        style="width:fit-content;margin: 0px; margin-right:5px; font-weight: bold;">
                                                        Crown</p>
                                                    <input style="width: fit-content;" current-color="black" type="checkbox" name=""
                                                        id="" {{ $dentalLabOrder->zirconia_crown == '1' ? 'checked' : '' }}  disabled>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p
                                                        style="width:fit-content;margin: 0px; margin-right:5px; font-weight: bold;">
                                                        Bridges</p>
                                                    <input style="width: fit-content;" current-color="brown" type="checkbox" name=""
                                                        id="" {{ $dentalLabOrder->zirconia_bridges == '1' ? 'checked' : '' }}  disabled>
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
                                                                        <td style="width:20px; text-align: center; border: 1px dotted black; border-top: none; border-left: none;"
                                                                            class="p-0">{{$dentalLabOrder->shade_main_1  ?? '.'}}</td>
                                                                        <td style="width:20px; text-align: center; border: 1px dotted black;  border-top: none;"
                                                                            class="p-0">{{$dentalLabOrder->shade_left_1_1 ?? '.'}}</td>
                                                                        <td style="width:20px; text-align: center; border: 1px dotted black; border-top: none; border-right: none; min-width: 0px;"
                                                                            class="p-0">{{$dentalLabOrder->shade_left_1_2 ?? '.'}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width:20px; text-align: center; border: 1px dotted black;  border-left: none;"
                                                                            class="p-0">D</td>
                                                                        <td style="width:20px; text-align: center; border: 1px dotted black;"
                                                                            class="p-0">{{$dentalLabOrder->shade_left_1_3 ?? '.'}}</td>
                                                                        <td style="width:20px; text-align: center; border: 1px dotted black; border-right: none; min-width: 0px;"
                                                                            class="p-0">{{$dentalLabOrder->shade_right_1_1 ?? '.'}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width:20px; text-align: center; border: 1px dotted black; border-bottom: none; border-left: none;"
                                                                            class="p-0">{{$dentalLabOrder->shade_right_1_2 ?? '.'}}</td>
                                                                        <td style="width:20px; text-align: center; border: 1px dotted black; border-bottom: none; "
                                                                            class="p-0">{{$dentalLabOrder->shade_right_1_3 ?? '.'}}</td>
                                                                        <td style="width:20px; text-align: center; border: 1px dotted black; border-bottom: none; border-right: none; min-width: 0px;"
                                                                            class="p-0">{{$dentalLabOrder->shade_right_2_4 ?? '.'}}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="col-4 m-0 p-0">
                                                            <table class="table">
                                                                <tbody>
                                                                    <tr>
                                                                        <td style="width:20px; text-align: center; border: 1px dotted  black; border-top: none; border-left: none;"
                                                                            class="p-0">{{$dentalLabOrder->shade_main_2 ?? '.'}}</td>
                                                                        <td style="width:20px; text-align: center; border: 1px dotted  black;  border-top: none;"
                                                                            class="p-0">{{$dentalLabOrder->shade_left_2_1 ?? '.'}}</td>
                                                                        <td style="width:20px; text-align: center; border: 1px dotted  black; border-top: none; border-right: none; min-width: 0px;"
                                                                            class="p-0">{{$dentalLabOrder->shade_left_2_2 ?? '.'}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width:20px; text-align: center; border: 1px dotted  black;  border-left: none;"
                                                                            class="p-0">D</td>
                                                                        <td style="width:20px; text-align: center; border: 1px dotted  black;"
                                                                            class="p-0">{{$dentalLabOrder->shade_left_2_3}} </td>
                                                                        <td style="width:20px; text-align: center; border: 1px dotted  black; border-right: none; min-width: 0px;"
                                                                            class="p-0">M</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width:20px; text-align: center; border: 1px dotted  black; border-bottom: none; border-left: none;"
                                                                            class="p-0">{{$dentalLabOrder->shade_right_2_1 ?? '.'}}</td>
                                                                        <td style="width:20px; text-align: center; border: 1px dotted  black; border-bottom: none; "
                                                                            class="p-0">{{$dentalLabOrder->shade_right_2_2 ?? '.'}}</td>
                                                                        <td style="width:20px; text-align: center; border: 1px dotted  black; border-bottom: none; border-right: none; min-width: 0px;"
                                                                            class="p-0">{{$dentalLabOrder->shade_right_2_3 ?? '.'}}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 m-0 p-0" style="position: relative; bottom: 0px;">
                                        <table class="table table-bordered border-dark">
                                            <tbody>
                                                <tr>
                                                    <td class="p-0 text-center" style="width: 33px;">
                                                        8
                                                        <input type="checkbox" name="shade_d_top_8" id="shade_d_top_8"
                                                            style="padding: 0px; margin:0px;" {{ isset($dentalLabOrder->shade_d_top_8) && $dentalLabOrder->shade_d_top_8 !== '' ? 'checked' : '' }}
 disabled>
                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">7
                                                        <input type="checkbox" name="shade_d_top_7" id="shade_d_top_7"
                                                            style="padding: 0px; margin:0px;"{{ isset($dentalLabOrder->shade_d_top_7) && $dentalLabOrder->shade_d_top_7 !== '' ? 'checked' : '' }}
 disabled>

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">6
                                                        <input type="checkbox" name="shade_d_top_6" id="shade_d_top_6"
                                                            style="padding: 0px; margin:0px;" {{ isset($dentalLabOrder->shade_d_top_6) && $dentalLabOrder->shade_d_top_6 !== '' ? 'checked' : '' }}
  disabled>

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">5
                                                        <input type="checkbox" name="shade_d_top_5" id="shade_d_top_5"
                                                            style="padding: 0px; margin:0px;"{{ isset($dentalLabOrder->shade_d_top_5) && $dentalLabOrder->shade_d_top_5 !== '' ? 'checked' : '' }}
  disabled>

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">4
                                                        <input type="checkbox" name="shade_d_top_4" id="shade_d_top_4"
                                                            style="padding: 0px; margin:0px;" {{ isset($dentalLabOrder->shade_d_top_4) && $dentalLabOrder->shade_d_top_4 !== '' ? 'checked' : '' }}
  disabled>

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">3
                                                        <input type="checkbox" name="shade_d_top_3" id="shade_d_top_3"
                                                            style="padding: 0px; margin:0px;" {{ isset($dentalLabOrder->shade_d_top_3) && $dentalLabOrder->shade_d_top_3 !== '' ? 'checked' : '' }}
  disabled>

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">2
                                                        <input type="checkbox" name="shade_d_top_2" id="shade_d_top_2"
                                                            style="padding: 0px; margin:0px;" {{ isset($dentalLabOrder->shade_d_top_2) && $dentalLabOrder->shade_d_top_2 !== '' ? 'checked' : '' }}
  disabled>

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">1
                                                        <input type="checkbox" name="shade_d_top_1" id="shade_d_top_1"
                                                            style="padding: 0px; margin:0px;"{{ isset($dentalLabOrder->shade_d_top_1) && $dentalLabOrder->shade_d_top_1 !== '' ? 'checked' : '' }}
  disabled>

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">1
                                                        <input type="checkbox" name="shade_d_bottom_1" id="shade_d_bottom_1"
                                                            style="padding: 0px; margin:0px;"{{ isset($dentalLabOrder->shade_d_bottom_1) && $dentalLabOrder->shade_d_bottom_1 !== '' ? 'checked' : '' }}  disabled>

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">2
                                                        <input type="checkbox" name="shade_d_bottom_2" id="shade_d_bottom_2"
                                                            style="padding: 0px; margin:0px;" {{ isset($dentalLabOrder->shade_d_bottom_2) && $dentalLabOrder->shade_d_bottom_2 !== '' ? 'checked' : '' }}  disabled>

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">3
                                                        <input type="checkbox" name="shade_d_bottom_3" id="shade_d_bottom_3"
                                                            style="padding: 0px; margin:0px;"{{ isset($dentalLabOrder->shade_d_bottom_3) && $dentalLabOrder->shade_d_bottom_3 !== '' ? 'checked' : '' }}  disabled>

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">4
                                                        <input type="checkbox" name="shade_d_bottom_4" id="shade_d_bottom_4"
                                                            style="padding: 0px; margin:0px;"{{ isset($dentalLabOrder->shade_d_bottom_4) && $dentalLabOrder->shade_d_bottom_4 !== '' ? 'checked' : '' }}  disabled>

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">5
                                                        <input type="checkbox" name="shade_d_bottom_5" id="shade_d_bottom_5"
                                                            style="padding: 0px; margin:0px;" {{ isset($dentalLabOrder->shade_d_bottom_5) && $dentalLabOrder->shade_d_bottom_5 !== '' ? 'checked' : '' }}  disabled>

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">6
                                                        <input type="checkbox" name="shade_d_bottom_6" id="shade_d_bottom_6"
                                                            style="padding: 0px; margin:0px;" {{ isset($dentalLabOrder->shade_d_bottom_6) && $dentalLabOrder->shade_d_bottom_6 !== '' ? 'checked' : '' }}  disabled>

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">7
                                                        <input type="checkbox" name="shade_d_bottom_7" id="shade_d_bottom_7"
                                                            style="padding: 0px; margin:0px;"{{ isset($dentalLabOrder->shade_d_bottom_7) && $dentalLabOrder->shade_d_bottom_7 !== '' ? 'checked' : '' }}  disabled>

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px; min-width:0px;">8
                                                        <input type="checkbox" name="shade_d_bottom_8" id="shade_d_bottom_8"
                                                            style="padding: 0px; margin:0px;"{{ isset($dentalLabOrder->shade_d_bottom_8) && $dentalLabOrder->shade_d_bottom_8 !== '' ? 'checked' : '' }}  disabled>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="p-0 text-center" style="width: 33px;">
                                                        8
                                                        <input type="checkbox" name="shade_m_top_8" id="shade_m_top_8"
                                                            style="padding: 0px; margin:0px;"  {{ isset($dentalLabOrder->shade_m_top_8) && $dentalLabOrder->shade_m_top_8 !== '' ? 'checked' : '' }}  disabled>
                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">7
                                                        <input type="checkbox" name="shade_m_top_7" id="shade_m_top_7"
                                                            style="padding: 0px; margin:0px;"  {{ isset($dentalLabOrder->shade_m_top_7) && $dentalLabOrder->shade_m_top_7 !== '' ? 'checked' : '' }}  disabled>

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">6
                                                        <input type="checkbox" name="shade_m_top_6" id="shade_m_top_6"
                                                            style="padding: 0px; margin:0px;" {{ isset($dentalLabOrder->shade_m_top_6) && $dentalLabOrder->shade_m_top_6 !== '' ? 'checked' : '' }}  disabled>

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">5
                                                        <input type="checkbox" name="shade_m_top_5" id="shade_m_top_5"
                                                            style="padding: 0px; margin:0px;" {{ isset($dentalLabOrder->shade_m_top_5) && $dentalLabOrder->shade_m_top_5 !== '' ? 'checked' : '' }}  disabled>

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">4
                                                        <input type="checkbox" name="shade_m_top_4" id="shade_m_top_4"
                                                            style="padding: 0px; margin:0px;" {{ isset($dentalLabOrder->shade_m_top_4) && $dentalLabOrder->shade_m_top_4 !== '' ? 'checked' : '' }}  disabled>

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">3
                                                        <input type="checkbox" name="shade_m_top_3" id="shade_m_top_3"
                                                            style="padding: 0px; margin:0px;"  {{ isset($dentalLabOrder->shade_m_top_3) && $dentalLabOrder->shade_m_top_3 !== '' ? 'checked' : '' }}  disabled>

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">2
                                                        <input type="checkbox" name="shade_m_top_2" id="shade_m_top_2"
                                                            style="padding: 0px; margin:0px;"  {{ isset($dentalLabOrder->shade_m_top_2) && $dentalLabOrder->shade_m_top_2 !== '' ? 'checked' : '' }}  disabled>

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">1
                                                        <input type="checkbox" name="shade_m_top_1" id="shade_m_top_1"
                                                            style="padding: 0px; margin:0px;"  {{ isset($dentalLabOrder->shade_m_top_1) && $dentalLabOrder->shade_m_top_1 !== '' ? 'checked' : '' }}  disabled>

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">1
                                                        <input type="checkbox" name="shade_m_bottom_1" id="shade_m_bottom_1"
                                                            style="padding: 0px; margin:0px;" {{ isset($dentalLabOrder->shade_m_bottom_1) && $dentalLabOrder->shade_m_bottom_1 !== '' ? 'checked' : '' }}
  disabled>

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">2
                                                        <input type="checkbox" name="shade_m_bottom_2" id="shade_m_bottom_2"
                                                            style="padding: 0px; margin:0px;" {{ isset($dentalLabOrder->shade_m_bottom_2) && $dentalLabOrder->shade_m_bottom_2 !== '' ? 'checked' : '' }}
  disabled>

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">3
                                                        <input type="checkbox" name="shade_m_bottom_3" id="shade_m_bottom_3"
                                                            style="padding: 0px; margin:0px;" {{ isset($dentalLabOrder->shade_m_bottom_3) && $dentalLabOrder->shade_m_bottom_3 !== '' ? 'checked' : '' }}
 disabled>

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">4
                                                        <input type="checkbox" name="shade_m_bottom_4" id="shade_m_bottom_4"
                                                            style="padding: 0px; margin:0px;" {{ isset($dentalLabOrder->shade_m_bottom_4) && $dentalLabOrder->shade_m_bottom_4 !== '' ? 'checked' : '' }}
  disabled>

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">5
                                                        <input type="checkbox" name="shade_m_bottom_5" id="shade_m_bottom_5"
                                                            style="padding: 0px; margin:0px;" {{ isset($dentalLabOrder->shade_m_bottom_5) && $dentalLabOrder->shade_m_bottom_5 !== '' ? 'checked' : '' }}
  disabled>

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">6
                                                        <input type="checkbox" name="shade_m_bottom_6" id="shade_m_bottom_6"
                                                            style="padding: 0px; margin:0px;" {{ isset($dentalLabOrder->shade_m_bottom_6) && $dentalLabOrder->shade_m_bottom_6 !== '' ? 'checked' : '' }}
  disabled>

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px;">7
                                                        <input type="checkbox" name="shade_m_bottom_7" id="shade_m_bottom_7"
                                                            style="padding: 0px; margin:0px;" {{ isset($dentalLabOrder->shade_m_bottom_7) && $dentalLabOrder->shade_m_bottom_7 !== '' ? 'checked' : '' }}
  disabled>

                                                    </td>
                                                    <td class="p-0 text-center" style="width: 33px; min-width:0px;">8
                                                        <input type="checkbox" name="shade_m_bottom_8" id="shade_m_bottom_8"
                                                            style="padding: 0px; margin:0px;" {{ isset($dentalLabOrder->shade_m_bottom_8) && $dentalLabOrder->shade_m_bottom_8 !== '' ? 'checked' : '' }}
  disabled>

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
                                                    <input style="width: fit-content;" type="checkbox" name=""
                                                        id="" {{ $dentalLabOrder->e_max_milled == '1' ? 'checked' : '' }}  disabled>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">PRESSED
                                                    </p>
                                                    <input style="width: fit-content;" type="checkbox" name=""
                                                        id="" {{ $dentalLabOrder->e_max_crown == '1' ? 'checked' : '' }}  disabled>
                                                </div>
                                            </div>
                                            <div class="ml-5 my-auto">
                                                <div class="row justify-content-between">
                                                    <p
                                                        style="width:fit-content;margin: 0px; margin-right:5px; font-weight: bold;">
                                                        Non Pre
                                                        Veneers</p>
                                                    <input style="width: fit-content;" current-color="yellow" type="checkbox" name=""
                                                        id="" {{ $dentalLabOrder->e_max_non_pres == '1' ? 'checked' : '' }}  disabled>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p
                                                        style="width:fit-content;margin: 0px; margin-right:5px; font-weight: bold;">
                                                        Veneers</p>
                                                    <input style="width: fit-content;" current-color="purple" type="checkbox" name=""
                                                        id=""{{ $dentalLabOrder->e_max_veneers == '1' ? 'checked' : '' }}  disabled>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p
                                                        style="width:fit-content;margin: 0px; margin-right:5px; font-weight: bold;">
                                                        Crown</p>
                                                    <input style="width: fit-content;" current-color="orange" type="checkbox" name=""
                                                        id="" {{ $dentalLabOrder->e_max_crown == '1' ? 'checked' : '' }}  disabled>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p
                                                        style="width:fit-content;margin: 0px; margin-right:5px; font-weight: bold;">
                                                        Bridges</p>
                                                    <input style="width: fit-content;" current-color="pink" type="checkbox" name=""
                                                        id="" {{ $dentalLabOrder->e_max_bridges == '1' ? 'checked' : '' }}  disabled>
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
                                                        <input style="width: fit-content;" type="checkbox" name=""
                                                            id="" {{ $dentalLabOrder->peek_removable_partial_denture == '1' ? 'checked' : '' }}  disabled>
                                                        <p
                                                            style="width:fit-content; font-weight: bold; margin: 0px; font-weight: bold;">
                                                            Removable Partial Denture</p>
                                                    </div>
                                                    <div class="row justify-content-between">
                                                        <input style="width: fit-content;" type="checkbox" name=""
                                                            id="" {{ $dentalLabOrder->peek_fixed_prosthetic_framework == '1' ? 'checked' : '' }}  disabled>
                                                        <p
                                                            style="width:fit-content; font-weight: bold; margin: 0px; font-weight: bold;">
                                                            Fixed Prosthetic Framework</p>
                                                    </div>
                                                    <div class="row justify-content-between">
                                                        <input style="width: fit-content;" type="checkbox" name=""
                                                            id="" {{ $dentalLabOrder->peek_attachment_restorations == '1' ? 'checked' : '' }}  disabled>
                                                        <p
                                                            style="width:fit-content; font-weight: bold; margin: 0px; font-weight: bold;">
                                                            Attachment Restorations</p>
                                                    </div>
                                                </div>
                                                <div class="col-10 row" style="margin-left: 37px;">
                                                    <div class="row col-4 justify-content-between">
                                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">Screw
                                                        </p>
                                                        <input style="width: fit-content;" type="checkbox" name=""
                                                            id="" {{ $dentalLabOrder->peek_screw == '1' ? 'checked' : '' }}  disabled>
                                                    </div>
                                                    <div class="row col-4 ml-2 justify-content-between">
                                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">
                                                            Retained
                                                        </p>
                                                        <input style="width: fit-content;" type="checkbox" name=""
                                                            id="" {{ $dentalLabOrder->peek_retained == '1' ? 'checked' : '' }}  disabled>
                                                    </div>
                                                    <div class="row col-4 ml-2 justify-content-between">
                                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">
                                                            Implant
                                                        </p>
                                                        <input style="width: fit-content;" type="checkbox" name=""
                                                            id="" {{ $dentalLabOrder->peek_implant == '1' ? 'checked' : '' }}  disabled>
                                                    </div>
                                                </div>
                                                <div class="row col-10 justify-content-between"
                                                    style="margin-left: 37px; width: 86.333333%;">
                                                    <div class="row col-5 justify-content-between">
                                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">
                                                            Supported
                                                        </p>
                                                        <input style="width: fit-content;" type="checkbox" name=""
                                                            id="" {{ $dentalLabOrder->peek_supported == '1' ? 'checked' : '' }}  disabled>
                                                    </div>
                                                    <div class="row col-7 justify-content-between">
                                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">
                                                            Superstructures</p>
                                                        <input style="width: fit-content;" type="checkbox" name=""
                                                            id="" {{ $dentalLabOrder->peek_superstructures == '1' ? 'checked' : '' }}  disabled>
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
                                                    <input style="width: fit-content;" type="checkbox" name=""
                                                        id="" {{ $dentalLabOrder->pfm_porcelain == '1' ? 'checked' : '' }}  disabled>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p
                                                        style="width:fit-content;margin: 0px; margin-right:5px; font-weight: bold;">
                                                        NON-PRES</p>
                                                    <input style="width: fit-content;" type="checkbox" name=""
                                                        id="" {{ $dentalLabOrder->pfm_non_pres == '1' ? 'checked' : '' }}  disabled>
                                                </div>
                                            </div>
                                            <div class="col-4 ml-5 my-auto">
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">Implant
                                                    </p>
                                                    <input style="width: fit-content;" type="checkbox" current-color="cyan" name=""
                                                        id="" {{ $dentalLabOrder->pfm_implant == '1' ? 'checked' : '' }}  disabled>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">Post &
                                                        Core
                                                    </p>
                                                    <input style="width: fit-content;" type="checkbox" current-color="megenta" name=""
                                                        id="" {{ $dentalLabOrder->pfm_post_and_core == '1' ? 'checked' : '' }}  disabled>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">Crown</p>
                                                    <input style="width: fit-content;" type="checkbox" current-color="gray" name=""
                                                        id="" {{ $dentalLabOrder->pfm_crown == '1' ? 'checked' : '' }}  disabled>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">Bridges
                                                    </p>
                                                    <input style="width: fit-content;" type="checkbox" current-color="lima" name=""
                                                        id="" {{ $dentalLabOrder->pfm_bridges == '1' ? 'checked' : '' }}  disabled>
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
                                                    <input style="width: fit-content;" type="checkbox" name=""
                                                        id="" {{ $dentalLabOrder->removable_diagnostic_wax_up == '1' ? 'checked' : '' }}  disabled >
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">Hybrid
                                                        Denture
                                                    </p>
                                                    <input style="width: fit-content;" type="checkbox" name=""
                                                        id="" {{ $dentalLabOrder->removable_hybrid_denture == '1' ? 'checked' : '' }}  disabled>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">Tooth
                                                        Addition
                                                    </p>
                                                    <input style="width: fit-content;" type="checkbox" name=""
                                                        id="" {{ $dentalLabOrder->removable_tooth_addition == '1' ? 'checked' : '' }}  disabled>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">Over
                                                        Denture
                                                    </p>
                                                    <input style="width: fit-content;" type="checkbox" name=""
                                                        id="" {{ $dentalLabOrder->removable_over_denture == '1' ? 'checked' : '' }}  disabled>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">Relining
                                                        hard/soft</p>
                                                    <input style="width: fit-content;" type="checkbox" name=""
                                                        id="" {{ $dentalLabOrder->removable_relining_hard_soft == '1' ? 'checked' : '' }}  disabled>
                                                </div>
                                            </div>
                                            <div class="ml-5 my-auto" style="width: 21%;">
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">Flexible
                                                    </p>
                                                    <input style="width: fit-content;" type="checkbox" name=""
                                                        id="" {{ $dentalLabOrder->removable_flexible == '1' ? 'checked' : '' }}  disabled>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">Veneers
                                                    </p>
                                                    <input style="width: fit-content;" type="checkbox" name=""
                                                        id="" {{ $dentalLabOrder->removable_veneers == '1' ? 'checked' : '' }}  disabled>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">Crown</p>
                                                    <input style="width: fit-content;" type="checkbox" name=""
                                                        id="" {{ $dentalLabOrder->removable_crown == '1' ? 'checked' : '' }}  disabled>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">Bridges
                                                    </p>
                                                    <input style="width: fit-content;" type="checkbox" name=""
                                                        id="" {{ $dentalLabOrder->removable_bridges == '1' ? 'checked' : '' }}  disabled>
                                                </div>
                                            </div>
                                            <div class="col-10 row" style="margin-left: 37px;">
                                                <div class="row col-4 justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">Screw</p>
                                                    <input style="width: fit-content;" type="checkbox" name=""
                                                        id="" {{ $dentalLabOrder->removable_screw == '1' ? 'checked' : '' }}  disabled>
                                                </div>
                                                <div class="row col-4 ml-2 justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">Retained
                                                    </p>
                                                    <input style="width: fit-content;" type="checkbox" name=""
                                                        id="" {{ $dentalLabOrder->removable_retained == '1' ? 'checked' : '' }}  disabled>
                                                </div>
                                                <div class="row col-4 ml-2 justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">Implant
                                                    </p>
                                                    <input style="width: fit-content;" type="checkbox" name=""
                                                        id="" {{ $dentalLabOrder->removable_implant == '1' ? 'checked' : '' }}  disabled>
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
                                                        <input style="width: fit-content;" type="checkbox" name=""
                                                            id="" {{ $dentalLabOrder->items_imp == '1' ? 'checked' : '' }}  disabled>
                                                    </div>
                                                    <div class="row justify-content-between">
                                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">
                                                            Partial
                                                        </p>
                                                        <input style="width: fit-content;" type="checkbox" name=""
                                                            id="" {{ $dentalLabOrder->items_partial == '1' ? 'checked' : '' }}  disabled>
                                                    </div>
                                                    <div class="row justify-content-between">
                                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">
                                                            Digital
                                                            Impression</p>
                                                        <input style="width: fit-content;" type="checkbox" name=""
                                                            id="" {{ $dentalLabOrder->items_digital_impression == '1' ? 'checked' : '' }}  disabled>
                                                    </div>
                                                </div>
                                                <div style="width: 21%; padding-left: 26px;">
                                                    <div class="row justify-content-between">
                                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">Bite
                                                        </p>
                                                        <input style="width: fit-content;" type="checkbox" name=""
                                                            id="" {{ $dentalLabOrder->items_bite == '1' ? 'checked' : '' }}  disabled>
                                                    </div>
                                                    <div class="row justify-content-between">
                                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">Photo
                                                        </p>
                                                        <input style="width: fit-content;" type="checkbox" name=""
                                                            id="" {{ $dentalLabOrder->items_photo == '1' ? 'checked' : '' }}  disabled>
                                                    </div>
                                                    <div class="row justify-content-between">
                                                        <p style="width:fit-content;margin: 0px; font-weight: bold;"></p>
                                                        <!-- <input style="width: fit-content;" type="checkbox" name="" id=""   disabled> -->
                                                    </div>
                                                </div>
                                                <div style="width: 40%; padding-inline: 22px;">
                                                    <div class="row justify-content-between">
                                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">Study
                                                            Models</p>
                                                        <input style="width: fit-content;" type="checkbox" name=""
                                                            id="" {{ $dentalLabOrder->items_study_models == '1' ? 'checked' : '' }} disabled  >
                                                    </div>
                                                    <div class="row justify-content-between">
                                                        <p style="width:fit-content;margin: 0px; font-weight: bold;">Shade
                                                            Tab
                                                        </p>
                                                        <input style="width: fit-content;" type="checkbox" name=""
                                                            id="" {{ $dentalLabOrder->items_shade_tab == '1' ? 'checked' : '' }} disabled>
                                                    </div>
                                                    <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">{{ $dentalLabOrder->items_furthers }} </p>
                                                      <input style="width: fit-content;" type="checkbox" name="" id="" 
                                                       {{ $dentalLabOrder->items_further == '1' ? 'checked' : '' }} disabled>
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
                                                    <input style="width: fit-content;" type="checkbox" name=""
                                                        id=""  {{ $dentalLabOrder->appliance_ortho== '1' ? 'checked' : '' }} disabled>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">Retainer
                                                    </p>
                                                    <input style="width: fit-content;" type="checkbox" name=""
                                                        id=""  {{ $dentalLabOrder->appliance_retainer == '1' ? 'checked' : '' }} disabled>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">Wire</p>
                                                    <input style="width: fit-content;" type="checkbox" name=""
                                                        id=""  {{ $dentalLabOrder->appliance_wire == '1' ? 'checked' : '' }} disabled>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">Hyrax</p>
                                                    <input style="width: fit-content;" type="checkbox" name=""
                                                        id=""  {{ $dentalLabOrder->appliance_hyrax == '1' ? 'checked' : '' }} disabled>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">TPA</p>
                                                    <input style="width: fit-content;" type="checkbox" name=""
                                                        id=""  {{ $dentalLabOrder->appliance_tpa == '1' ? 'checked' : '' }} disabled>
                                                </div>
                                            </div>
                                            <div class="ml-5 my-auto" style="width: 42%;">
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">Night
                                                        Guard
                                                    </p>
                                                    <input style="width: fit-content;" type="checkbox" name=""
                                                        id=""  {{ $dentalLabOrder->appliance_night_guard == '1' ? 'checked' : '' }} disabled>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">Occlusal
                                                        Splint</p>
                                                    <input style="width: fit-content;" type="checkbox" name=""
                                                        id=""  {{ $dentalLabOrder->appliance_occlusal_splint == '1' ? 'checked' : '' }} disabled>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">Sheet
                                                        Press
                                                        Retainer
                                                    </p>
                                                    <input style="width: fit-content;" type="checkbox" name=""
                                                        id=""  {{ $dentalLabOrder->appliance_sheet_press_retainer == '1' ? 'checked' : '' }} disabled>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">Obturator
                                                    </p>
                                                    <input style="width: fit-content;" type="checkbox" name=""
                                                        id=""  {{ $dentalLabOrder->appliance_obturator == '1' ? 'checked' : '' }} disabled>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <p style="width:fit-content;margin: 0px; font-weight: bold;">Space
                                                        Maintainer</p>
                                                    <input style="width: fit-content;" type="checkbox" name=""
                                                        id=""  {{ $dentalLabOrder->appliance_space_maintainer == '1' ? 'checked' : '' }} disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class=" col-12 m-0 px-4 py-1">
                                    <span style="font-size: 14px; font-weight: bold; width: auto;">Furthur
                                        Instructions:</span><br>
                                    <div
                                        style=" width: 100%; height: 20px; border-bottom: 1px solid black;padding-top: 2px; padding-inline: 15px;">{{ $dentalLabOrder->further_instructions }} 
                                    </div>
                                    <div
                                        style=" width: 100%; height: 20px; border-bottom: 1px solid black;padding-top: 2px; padding-inline: 15px;">
                                    </div>
                                    <div
                                        style=" width: 100%; height: 20px; border-bottom: 1px solid black;padding-top: 2px; padding-inline: 15px;">
                                    </div>
                                </div>
                                <div class=" col-12 m-0 px-4 pt-1 pb-4">
                                    <span style="font-size: 14px; font-weight: bold; width: auto;">Lab
                                        Details:</span><br>
                                    <div
                                        style=" width: 100%; height: 20px; border-bottom: 1px solid black;padding-top: 2px; padding-inline: 15px;">{{ $dentalLabOrder->instructions_from_lab  }} 
                                    </div>
                                    <div
                                        style=" width: 100%; height: 20px; border-bottom: 1px solid black;padding-top: 2px; padding-inline: 15px;">
                                    </div>
                                    <div
                                        style=" width: 100%; height: 20px; border-bottom: 1px solid black;padding-top: 2px; padding-inline: 15px;">
                                    </div>
                                </div>
                            </div>


                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).on('click', '#generatePrint', function() {
            $('#print-section').show();
            var printContent = $('#print-section').html();
            $('body').html(printContent);
            window.print();
            location.reload();
        });
    </script>
@endsection
