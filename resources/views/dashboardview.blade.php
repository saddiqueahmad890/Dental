@extends('layouts.layout')

@section('one_page_css')
    <link href="{{ asset('assets/css/dashboard.css') }}" rel="stylesheet">
@endsection
@section('one_page_js')
    <!-- ChartJS -->
    <script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>
@endsection
@section('content')
    <style>
        .custom-box {
            height: 126px;
        }

        .custom-box .info-box {
            height: inherit;
        }
    </style>


    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h2>@lang('Dashboard')</h2>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">@lang('Dashboard')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="row col-12">




        <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-4 mt-3 custom-box" style="text-decoration: none;">
            <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="fas fa-user-injured"></i></span>
                <div class="info-box-content" style="position:relative;">
                    <span class="info-box-text d-flex">@lang('Patient:') <span class="info-box-number">
                            {{ $dashboardCounts['patients'] }}</span></span>
                    <span class="info-box-text d-flex">@lang('Active Patient:')<span
                            class="info-box-number">{{ $dashboardCounts['active_patients'] }}</span></span>
                    <span class="info-box-text d-flex">@lang('Inactive Patient:')<span
                            class="info-box-number">{{ $dashboardCounts['nonactive_patients'] }}</span></span>
                    <a href='{{ route('patient-details.index') }}' class="text-decoration-underline"
                        style="position:absolute; bottom:0px;">View All</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-4 mt-3 custom-box" style="text-decoration: none;">
            <div class="info-box">
                <span class="info-box-icon bg-danger"><i class="fas fa-calendar-check"></i></span>
                <div class="info-box-content" style="position:relative;">
                    <span class="info-box-text d-flex">@lang('Patient Appointment:')<span class="info-box-number">
                            {{ $dashboardCounts['appointments'] }}</span></span>
                    <span class="info-box-text d-flex">@lang('Processed Appointments:')<span
                            class="info-box-number">{{ $dashboardCounts['processed'] }}</span></span>
                    <span class="info-box-text d-flex">@lang('Cancelled Appointments:')<span
                            class="info-box-number">{{ $dashboardCounts['cancel'] }}</span></span>
                    <a href='{{ route('patient-appointments.index') }}' class="text-decoration-underline"
                        style="position:absolute; bottom:0px;">View All</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-4 mt-3 custom-box" style="text-decoration: none;">
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fas fa-user-md"></i></span>
                <div class="info-box-content" style="position:relative;">
                    <span class="info-box-text d-flex">@lang('Doctor: ')<span class="info-box-number">
                            {{ $dashboardCounts['doctors'] }}</span></span>
                    <span class="info-box-text d-flex">@lang('Active Doctor:')<span
                            class="info-box-number">{{ $dashboardCounts['active_doctors'] }}</span></span>
                    <span class="info-box-text d-flex">@lang('Inactive Doctor:')<span
                            class="info-box-number">{{ $dashboardCounts['nonactive_doctors'] }}</span></span>
                    <a href='{{ route('doctor-details.index') }}' class="text-decoration-underline"
                        style="position:absolute; bottom:0px;">View All</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-4 mt-3 custom-box" style="text-decoration: none;">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fas fa-bezier-curve"></i></span>
                <div class="info-box-content" style="position:relative;">
                    <span class="info-box-text d-flex">@lang('Exam Investigation'):<span
                            class="info-box-number">{{ $dashboardCounts['exam_investigation'] }}</span></span>
                    <a href='{{ route('exam-investigations.index') }}' class="text-decoration-underline"
                        style="position:absolute; bottom:0px;">View All</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-4 mt-3 custom-box" style="text-decoration: none;">
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fas fa-file-alt"></i></span>
                <div class="info-box-content" style="position:relative;">
                    <span class="info-box-text d-flex">@lang('Treatment Plans: ')<span
                            class="info-box-number">{{ $dashboardCounts['treatment_plans'] }}</span> </span>
                    <a href='{{ route('patient-treatment-plans.index') }}' class="text-decoration-underline"
                        style="position:absolute; bottom:0px;">View All</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-4 mt-3 custom-box" style="text-decoration: none;">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fas fa-pills"></i></span>
                <div class="info-box-content" style="position:relative;">
                    <span class="info-box-text d-flex">@lang('Prescription: ')<span
                            class="info-box-number">{{ $dashboardCounts['prescriptions'] }}</span> </span>
                    <a href='{{ route('prescriptions.index') }}' class="text-decoration-underline"
                        style="position:absolute; bottom:0px;">View All</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-4 mt-3 custom-box" style="text-decoration: none;">
            <div class="info-box">
                <span class="info-box-icon bg-danger"><i class="fas fa-file-invoice-dollar"></i></span>
                <div class="info-box-content" style="position:relative;">
                    <span class="info-box-text d-flex">@lang('Invoice Count:') <span
                            class="info-box-number">{{ $dashboardCounts['invoices'] }}</span></span>
                    <span class="info-box-text d-flex">@lang('Total Amount:')<span
                            class="info-box-number">{{ $dashboardCounts['total'] }}</span></span>
                    <span class="info-box-text d-flex">@lang('Paid Amount:')<span
                            class="info-box-number">{{ $dashboardCounts['paid'] }}</span></span>
                    <span class="info-box-text d-flex">@lang('Due Amount:')<span
                            class="info-box-number">{{ $dashboardCounts['total'] - $dashboardCounts['paid'] }}</span></span>
                    <a href='{{ route('invoices.index') }}' class="text-decoration-underline"
                        style="position:absolute; bottom:0px;">View All</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-4 mt-3 custom-box" style="text-decoration: none;">
            <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="fas fa-money-check"></i></span>
                <div class="info-box-content" style="position:relative;">
                    <span class="info-box-text d-flex  ">@lang('Expense Counts: ')<span
                            class="info-box-number ">{{ $dashboardCounts['payments'] }}</span></span>
                    <span class="info-box-text d-flex">@lang('Total Amount:')<span
                            class="info-box-number">{{ $dashboardCounts['totalAmount'] }}</span></span>
                    <a href='{{ route('payments.index') }}' class="text-decoration-underline"
                        style="position:absolute; bottom:0px;">View All</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-4 mt-3 custom-box" style="text-decoration: none;">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fas fa-money-check"></i></span>
                <div class="info-box-content" style="position:relative;">
                    <span class="info-box-text d-flex  ">@lang('Lab Reports: ')<span
                            class="info-box-number ">{{ $dashboardCounts['labReports'] }} </span></span>
                    <a href='{{ route('lab-reports.index') }}' class="text-decoration-underline"
                        style="position:absolute; bottom:0px;">View All</a>
                </div>
            </div>
        </div>
    </div>
    </div>

    {{-- <div class="row">
        <div class="col-md-12">
            <!-- BAR CHART -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title custom-color-white">@lang('Monthly Debit/Credit')</h3>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="barChart" class="custom-dashbord-mix"></canvas>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div> --}}

    {{-- <div class="row">
        <div class="col-md-6">
            <!-- BAR CHART -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title custom-color-white">{{ date('Y') }} @lang('Debit/Credit') </h3>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="donutChart1" class="custom-dashbord-mix"></canvas>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <div class="col-md-6">
            <!-- BAR CHART -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title custom-color-white">@lang('Overall Debit/Credit')</h3>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="donutChart2" class="custom-dashbord-mix"></canvas>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div> --}}
@endsection

@push('footer')
    <script src="{{ asset('assets/js/custom/dashboard/view.js') }}"></script>
@endpush
