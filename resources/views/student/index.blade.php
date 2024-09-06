@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- @can('student-create') --}}
                        <h3><a href="{{ route('student.create') }}" class="btn btn-outline btn-info">+ @lang('Add Student')</a>
                            <span class="pull-right"></span>
                        </h3>
                    {{-- @endcan --}}
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('Dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('Student List')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3>@lang('Student List')</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="laravel_datatable">
                        <thead>
                            <tr>
                                <th>@lang('ID')</th>
                                <th>@lang('Student Name')</th>
                                <th>@lang('Department')</th>
                                <th>@lang('Teacher')</th>
                                <th>@lang('Course Enrolled')</th>
                                <th>@lang('Address')</th>
                                <th>@lang('Birth-Date')</th>
                                <th data-orderable="false">@lang('Actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                                <tr>
                                    <td>{{ $student->id }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->department->name }}</td>
                                    <td>{{ $student->teacher->name }}</td>
                                    <td>{{ $student->course->course_name }}</td>
                                    <td>{{ $student->address }}</td>
                                    <td>{{ $student->dob }}</td>
                                    <td>
                                        <a href="{{ route('student.show', $student) }}" class="btn btn-info btn-outline btn-circle btn-lg" data-toggle="tooltip" title="@lang('View')"><i class="fa fa-eye ambitious-padding-btn"></i></a>
                                        {{-- @can('student-update') --}}
                                            <a href="{{ route('student.edit', $student) }}" class="btn btn-info btn-outline btn-circle btn-lg" data-toggle="tooltip" title="@lang('Edit')"><i class="fa fa-edit ambitious-padding-btn"></i></a>
                                        {{-- @endcan --}}
                                        {{-- @can('student-delete') --}}
                                            <a href="#" data-href="{{ route('student.destroy', $student) }}" class="btn btn-info btn-outline btn-circle btn-lg" data-toggle="modal" data-target="#myModal" title="@lang('Delete')"><i class="fa fa-trash ambitious-padding-btn"></i></a>
                                        {{-- @endcan --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $students->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@include('layouts.delete_modal')
@endsection
