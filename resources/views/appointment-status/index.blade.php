@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- @can('student-create') --}}
                        <h3><a href="{{ route('appointment-statuses.create') }}" class="btn btn-outline btn-info">+ @lang('Add New Option')</a>
                            <span class="pull-right"></span>
                        </h3>
                    {{-- @endcan --}}
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('Dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('Appointment Status')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Appointment Status')</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="laravel_datatable">
                        <thead>
                            <tr>
                            
                                <th>@lang('Name')</th>
                                <th>@lang('Status')</th>
                                <th data-orderable="false">@lang('Actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($appointmentStatuses as $appointmentStatus)
                                <tr>
                                 
                                    <td><span>{{ $appointmentStatus->name }}</span></td>
                                     <td>
                                         @if ($appointmentStatus->status == '1')
                                            <span class="badge badge-pill badge-success">@lang('Active')</span>
                                        @else
                                            <span class="badge badge-pill badge-danger">@lang('Inactive')</span>
                                        @endif
                                    </td>
                                    <td class="responsive-width">
                                        {{-- @can('student-update') --}}
                                            <a href="{{ route('appointment-statuses.edit', $appointmentStatus) }}" class="responsive-width-item btn btn-info btn-outline btn-circle btn-lg" data-toggle="tooltip" title="@lang('Edit')"><i class="fa fa-edit ambitious-padding-btn"></i></a>
                                        {{-- @endcan --}}
                                        {{-- @can('student-delete') --}}
                                            <a href="#" data-href="{{ route('appointment-statuses.destroy', $appointmentStatus) }}" class="responsive-width-item btn btn-info btn-outline btn-circle btn-lg" data-toggle="modal" data-target="#myModal" title="@lang('Delete')"><i class="fa fa-trash ambitious-padding-btn"></i></a>
                                        {{-- @endcan --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $appointmentStatuses->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
$(document).ready(function() {
    // Attach the click event listener
    $('a[data-toggle="modal"]').on('click', function(event) {
        // Prevent the default action
        event.preventDefault();
        
        // Extract the value of $DentalHistory from the data-href attribute
        var hrefValue = $(this).attr('data-href');
        var dentalHistory = hrefValue.split('/').pop();
        
       
    });
});
</script>
@include('layouts.delete_modal')
@endsection
