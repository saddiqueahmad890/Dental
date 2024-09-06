@extends('layouts.layout')
@section('one_page_css')
    <link href="{{ asset('assets/css/quill.snow.css') }}" rel="stylesheet">
@endsection
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('student.index') }}">@lang('Students')</a></li>
                    <li class="breadcrumb-item active">@lang('Students Info')</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<div class="row">
    <div class="col-md-3">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle" src="{{ asset('lara/student/' . $student->photo) }}" alt="Student Photo">
                </div>
                <h3 class="profile-username text-center">{{ $student->name }}</h3>
                {{-- <p class="text-muted text-center">{{ $student->specialist }}</p> --}}
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-header bg-info">
                <h3 class="card-title">@lang('Student Info')</h3>
                @can('doctor-detail-update')
                    <div class="card-tools">
                        <a href="{{ route('student.edit', $student) }}" class="btn btn-info">@lang('Edit')</a>
                    </div>
                @endcan
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name">@lang('Name')</label>
                            <p>{{ $student->name }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="department_id">@lang('Department')</label>
                            <p>{{ $student->department->name }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="teacher_id">@lang('Teacher')</label>
                            <p>{{ $student->teacher->name }}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="course_id">@lang('Course')</label>
                            <p>{{ $student->course->course_name }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="address">@lang('Address')</label>
                            <p>{{ $student->address }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="dob">@lang('Birth Day')</label>
                            <p>{{ $student->dob }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
