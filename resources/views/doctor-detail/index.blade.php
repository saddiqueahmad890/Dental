@extends('layouts.layout')
@section('content')
    <style>
        body {
            overscroll-x: hidden;
        }
    </style>

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @can('doctor-detail-create')
                        <h3>
                            <a href="{{ route('doctor-details.create') }}" class="btn btn-outline btn-info">
                                + @lang('Add Doctor')
                            </a>
                            <span class="pull-right"></span>
                        </h3>
                    @endcan
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('Dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('Doctor List')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Doctor List')</h3>
                    <div class="card-tools">
                        <a class="btn btn-primary float-right" target="_blank"
                            href="{{ route('doctor-details.index') }}?export=1">
                            <i class="fas fa-cloud-download-alt"></i> @lang('Export')
                        </a>
                        <button class="btn btn-default" data-toggle="collapse" href="#filter">
                            <i class="fas fa-filter"></i> @lang('Filter')
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="filter" class="collapse @if (request()->isFilterActive) show @endif">
                        <div class="card-body border">
                            <form action="" method="get" role="form" autocomplete="off">
                                <input type="hidden" name="isFilterActive" value="true">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>@lang('Name')</label>
                                            <input type="text" name="name" class="form-control"
                                                value="{{ request()->name }}" placeholder="@lang('Name')">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>@lang('Email')</label>
                                            <input type="text" name="email" class="form-control"
                                                value="{{ request()->email }}" placeholder="@lang('Email')">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>@lang('Phone')</label>
                                            <input type="text" name="phone" class="form-control"
                                                value="{{ request()->phone }}" placeholder="@lang('Phone')">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>@lang('Start Date')</label>
                                            <input type="text" name="start_date" id="start_date"
                                                class="form-control flatpickr" placeholder="@lang('Start Date')"
                                                value="{{ old('start_date', request()->start_date) }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>@lang('End Date')</label>
                                            <input type="text" name="end_date" id="end_date"
                                                class="form-control flatpickr" placeholder="@lang('End Date')"
                                                value="{{ old('end_date', request()->end_date) }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 align-content-center">
                                        <button type="submit" class="btn btn-info mt-4">@lang('Submit')</button>
                                        @if (request()->isFilterActive)
                                            <a href="{{ route('doctor-details.index') }}"
                                                class="btn btn-secondary mt-4">@lang('Clear')</a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <table class="table table-striped" id="laravel_datatable">
                        <thead>
                            <tr>

                                <th>Profile</th>
                                <th>@lang('Name')</th>
                                <th>@lang('Email')</th>
                                <th>@lang('Phone')</th>
                                {{-- <th>@lang('Department')</th> --}}
                                <th>@lang('Status')</th>
                                <th data-orderable="false">@lang('Actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($doctorDetails as $doctorDetail)
                                <tr>

                                    <td>
                                        <div class="text-center">
                                            @if ($doctorDetail->user->photo_url != null)
                                                <img class="profile-user-img img-fluid img-circle"
                                                    src="{{ $doctorDetail->user->photo_url }}" alt=""
                                                    style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;" />
                                            @else
                                                <img class="profile-user-img img-fluid rounded-circle"
                                                    src="{{ $defaultImagePath }}" alt="Default Profile Picture"
                                                    style="width: 50px; height: 50px; object-fit: cover;" />
                                            @endif
                                        </div>


                                    </td>
                                    <td>{{ $doctorDetail->user->name ?? '-' }}</td>
                                    <!-- Profile Picture Modal -->
                                    <div id="profilePicModal" class="modal fade" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">{{ $doctorDetail->user->name ?? '-' }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <img id="profilePicModalImg" src="" alt="Profile Picture"
                                                        style="width: 100%;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <td>{{ $doctorDetail->user->email ?? '-' }}</td>
                                    <td>{{ $doctorDetail->user->phone ?? '-' }}</td>
                                    {{-- <td>{{ $doctorDetail->hospitalDepartment->name }}</td> --}}
                                    <td>
                                        @if ($doctorDetail->user->status == 1)
                                            <span class="badge badge-pill badge-success">@lang('Active')</span>
                                        @else
                                            <span class="badge badge-pill badge-danger">@lang('Inactive')</span>
                                        @endif
                                    </td>
                                    <td class="responsive-width">
                                        @can('doctor-menu-read')
                                            <span class="responsive-width-item dropdown">
                                                <button class="btn btn-info btn-circle" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="fa fa-bars ambitious-padding-btn"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" style="font-size: 12px;"
                                                        href="{{ route('doctor-schedules.createFromDoctorDetails', ['userid' => $doctorDetail->user->id]) }}">
                                                        Create New Schedule
                                                    </a>
                                                    <hr style="margin: 0.25rem 0; border-top: 1px solid rgba(0, 0, 0, .1);">
                                                    <a class="dropdown-item" style="font-size: 12px;"
                                                        href="{{ route('doctor-schedules.index', ['userid' => $doctorDetail->user->id]) }}">
                                                        View Schedules
                                                    </a>
                                                    <hr style="margin: 0.25rem 0; border-top: 1px solid rgba(0, 0, 0, .1);">
                                                    <a class="dropdown-item" style="font-size: 12px;"
                                                        href="{{ route('patient-appointments.index', ['userid' => $doctorDetail->user->id]) }}">
                                                        View Appointments
                                                    </a>

                                                    <hr style="margin: 0.25rem 0; border-top: 1px solid rgba(0, 0, 0, .1);">
                                                    <a class="dropdown-item" style="font-size: 12px;"
                                                        href="{{ route('exam-investigations.index', ['doctor_id' => $doctorDetail->id]) }}">
                                                        View Exam & Investigations
                                                    </a>

                                                    <hr style="margin: 0.25rem 0; border-top: 1px solid rgba(0, 0, 0, .1);">
                                                    <a class="dropdown-item" style="font-size: 12px;"
                                                        href="{{ route('prescriptions.index', ['doctor_id' => $doctorDetail->user->id]) }}">
                                                        View Prescriptions
                                                    </a>
                                                </div>
                                            </span>
                                        @endcan
                                        <a href="{{ route('doctor-details.show', $doctorDetail) }}"
                                            class=" responsive-width-item btn btn-info btn-outline btn-circle btn-lg"
                                            data-toggle="tooltip" title="@lang('View')"><i
                                                class="fa fa-eye ambitious-padding-btn"></i></a>
                                        @can('doctor-detail-update')
                                            <a href="{{ route('doctor-details.edit', $doctorDetail) }}"
                                                class=" responsive-width-item btn btn-info btn-outline btn-circle btn-lg"
                                                data-toggle="tooltip" title="@lang('Edit')"><i
                                                    class="fa fa-edit ambitious-padding-btn"></i></a>
                                        @endcan
                                        @can('doctor-detail-delete')
                                            <a href="#"
                                                data-href="{{ route('doctor-details.destroy', $doctorDetail) }}"
                                                class="responsive-width-item btn btn-info btn-outline btn-circle btn-lg"
                                                data-toggle="modal" data-target="#myModal" title="@lang('Delete')"><i
                                                    class="fa fa-trash ambitious-padding-btn"></i></a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>


                    {{ $doctorDetails->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.profile-user-img').on('click', function() {
                var imgSrc = $(this).attr('src');
                $('#profilePicModalImg').attr('src', imgSrc);
                $('#profilePicModal').modal('show');
            });
        });
    </script>

    @include('layouts.delete_modal')
@endsection
