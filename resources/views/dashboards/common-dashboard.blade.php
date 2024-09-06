@extends('layouts.layout')

@section('one_page_css')
    {{-- <link rel="stylesheet" href="{{ asset('assets/plugins/fullcalendar/main.css') }}"> --}}
@endsection
@section('one_page_js')
    {{-- <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/plugins/fullcalendar/main.js') }}"></script> --}}
@endsection
@section('content')
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
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-body p-0">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function () {
            "use strict";
            function ini_events(ele) {
                ele.each(function () {
                    var eventObject = {
                        title: $.trim($(this).text())
                    }
                    $(this).data('eventObject', eventObject)
                    $(this).draggable({
                        zIndex        : 1070,
                        revert        : true,
                        revertDuration: 0
                    })
                })
            }
            ini_events($('#external-events div.external-event'))
            var Calendar = FullCalendar.Calendar;
            var Draggable = FullCalendar.Draggable;
            var calendarEl = document.getElementById('calendar');
            var calendar = new Calendar(calendarEl, {
                headerToolbar: {
                    left  : 'prev,next today',
                    center: 'title',
                    right : 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                themeSystem: 'bootstrap',
                events: [
                    @if (isset($patientAppointment) && !empty($patientAppointment))
                        @foreach($patientAppointment as $appointment)
                            @php
                                $pName = $appointment->user->name;
                                $appointmentDate = $appointment->appointment_date;
                                $startTime = $appointment->start_time;
                                $endTime = $appointment->end_time;

                                $start = $appointmentDate."T".$startTime;
                                $end = $appointmentDate."T".$endTime;
                            @endphp
                            {
                                title : '{{ $pName }}',
                                start : '{{ $start }}',
                                end : '{{ $end }}',
                            },
                        @endforeach
                    @endif

                    @if (isset($appointments) && !empty($appointments))
                        @foreach($appointments as $appointment)
                            @php
                                $pName = $appointment->doctor->name;
                                $appointmentDate = $appointment->appointment_date;
                                $startTime = $appointment->start_time;
                                $endTime = $appointment->end_time;

                                $start = $appointmentDate."T".$startTime;
                                $end = $appointmentDate."T".$endTime;
                            @endphp
                            {
                                title : '{{ $pName }}',
                                start : '{{ $start }}',
                                end : '{{ $end }}',
                            },
                        @endforeach
                    @endif

                    @if (isset($receptionistAppointments) && !empty($receptionistAppointments))
                        @foreach($receptionistAppointments as $appointment)
                            @php
                                $pName = $appointment->user->name;
                                $dName = $appointment->doctor->name;
                                $appointmentDate = $appointment->appointment_date;
                                $startTime = $appointment->start_time;
                                $endTime = $appointment->end_time;

                                $start = $appointmentDate."T".$startTime;
                                $end = $appointmentDate."T".$endTime;
                                $title = $pName." have a appointment with ".$dName;
                            @endphp
                            {
                                title : '{{ $title }}',
                                start : '{{ $start }}',
                                end : '{{ $end }}',
                            },
                        @endforeach
                    @endif
                ],
                editable  : true,
                droppable : true,
            });
            calendar.render();
        });
    </script>
@endsection
