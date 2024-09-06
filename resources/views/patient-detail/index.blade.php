@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @can('patient-detail-create')
                        <h3><a href="{{ route('patient-details.create') }}" class="btn btn-outline btn-info">+
                                @lang('Add Patient')</a>
                            <span class="pull-right"></span>
                        </h3>
                    @endcan
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('Dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('Patient List')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Patient List') </h3>
                    <div class="card-tools">

                        <a class="btn btn-primary float-right" target="_blank"
                            href="{{ route('patient-details.index') }}?export=1">
                            <i class="fas fa-cloud-download-alt"></i> @lang('Export')
                        </a>
                        <button class="btn btn-default" data-toggle="collapse" href="#filter"><i class="fas fa-filter"></i>
                            @lang('Filter')</button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="filter" class="collapse @if (request()->isFilterActive) show @endif">
                        <div class="card-body border">
                            <form action="" method="get" role="form" autocomplete="off">
                                <input type="hidden" name="isFilterActive" value="true">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>@lang('Name')</label>
                                            <input type="text" name="name" class="form-control"
                                                value="{{ request()->name }}" placeholder="@lang('Name')">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>@lang('MRN Number')</label>
                                            <input type="text" name="mrn_number" class="form-control"
                                                value="{{ request()->mrn_number }}" placeholder="@lang('MRN Number')">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>@lang('Start Date')</label>
                                            <input type="text" name="start_date" id="start_date"
                                                class="form-control flatpickr" placeholder="@lang('Start Date')"
                                                value="{{ old('start_date', request()->start_date) }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>@lang('End Date')</label>
                                            <input type="text" name="end_date" id="end_date"
                                                class="form-control flatpickr" placeholder="@lang('End Date')"
                                                value="{{ old('end_date', request()->end_date) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-info">@lang('Submit')</button>
                                        @if (request()->isFilterActive)
                                            <a href="{{ route('patient-details.index') }}"
                                                class="btn btn-secondary">@lang('Clear')</a>
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
                                <th style="min-width: 100px;">@lang('MRN Number')</th>
                                <th>@lang('Phone')</th>
                                <th>@lang('Area')</th>
                                <th>@lang('City')</th>
                                <th>@lang('Actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($patientDetails as $patientDetail)
                                <tr>
                                    <td class="col-2">
                                        @if ($patientDetail->profilePicture)
                                            <img class="profile-user-img img-fluid img-circle"
                                                src="{{ asset('storage/' . $patientDetail->profilePicture) }}"
                                                alt="Profile Picture"
                                                style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;" />
                                        @else
                                            <img class="profile-user-img img-fluid img-circle"
                                                src="{{ asset('assets/images/profile/male.png') }}"
                                                alt="Default Profile Picture" class="img-thumbnail"
                                                style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;" />
                                        @endif
                                    </td>
                                    <td>{{ $patientDetail->name }}</td>
                                    <!-- Profile Picture Modal -->
                                    <div id="profilePicModal" class="modal fade" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalPatientName"></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <img id="profilePicModalImg" src="" alt="Profile Picture" style="width: 100%;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <td>{{ isset($patientDetail->patientDetails->mrn_number) ? $patientDetail->patientDetails->mrn_number : '-' }}
                                    </td>
                                    <td>{{ $patientDetail->phone }}</td>
                                    <td>{{ $patientDetail->patientDetails ? $patientDetail->patientDetails->area : '-' }}
                                    </td>
                                    <td>{{ $patientDetail->patientDetails ? $patientDetail->patientDetails->city : '-' }}
                                    </td>
                                    <td class="col-2 responsive-width">
                                        <span class="responsive-width-item dropdown">
                                            <button class="btn btn-info btn-circle" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <i class="fa fa-bars ambitious-padding-btn"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                @can('consultancey-create')
                                                <a class="dropdown-item" style="font-size: 12px;"
                                                    href="{{ route('consultancey-fees.create', ['userid' => $patientDetail->id]) }}">Add
                                                    Consultancy
                                                    Fee</a>
                                                    <hr style="margin: 0.25rem 0; border-top: 1px solid rgba(0, 0, 0, .1);">
                                                    @endcan
                                                <a class="dropdown-item" style="font-size: 12px;"
                                                    href="{{ route('patient-details.history', $patientDetail->id) }}">
                                                    View History
                                                </a>

                                                @can('patient-appointment-create')
                                                <hr style="margin: 0.25rem 0; border-top: 1px solid rgba(0, 0, 0, .1);">
                                                <a class="dropdown-item" style="font-size: 12px;"
                                                    href="{{ route('patient-appointments.createFromPatientDetails', ['userid' => $patientDetail->id]) }}">
                                                    Create Appointment
                                                </a>

                                                @endcan

                                            </div>
                                        </span>
                                        <a href="{{ route('patient-details.show', $patientDetail) }}"
                                            class="responsive-width-item btn btn-info btn-outline btn-circle btn-lg"
                                            data-toggle="tooltip" title="@lang('View')">
                                            <i class="fa fa-eye ambitious-padding-btn"></i>
                                        </a>
                                        @can('patient-detail-update')
                                            <a href="{{ route('patient-details.edit', $patientDetail) }}"
                                                class="responsive-width-item btn btn-info btn-outline btn-circle btn-lg"
                                                data-toggle="tooltip" title="@lang('Edit')">
                                                <i class="fa fa-edit ambitious-padding-btn"></i>
                                            </a>
                                        @endcan
                                        @can('patient-detail-delete')
                                            <a href="#"
                                                data-href="{{ route('patient-details.destroy', $patientDetail) }}"
                                                class="responsive-width-item btn btn-info btn-outline btn-circle btn-lg"
                                                data-toggle="modal" data-target="#myModal" title="@lang('Delete')">
                                                <i class="fa fa-trash ambitious-padding-btn"></i>
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $patientDetails->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.profile-user-img').on('click', function() {
                var imgSrc = $(this).attr('src');
                var patientName = $(this).closest('tr').find('td:eq(1)').text(); // Assuming Name is in the second column

                $('#profilePicModalImg').attr('src', imgSrc);
                $('#modalPatientName').text(patientName);
                $('#profilePicModal').modal('show');
            });
        });
    </script>

    @include('layouts.delete_modal')
@endsection
