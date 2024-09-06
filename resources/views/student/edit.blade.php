@extends('layouts.layout')
@section('one_page_css')
<link href="{{ asset('assets/css/quill.snow.css') }}" rel="stylesheet">

@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3><a href="{{ route('student.index') }}" class="btn btn-outline btn-info">
                        @lang('View All')</a>
                    <span class="pull-right"></span>
                </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('student.index') }}">@lang('Students')</a></li>
                        <li class="breadcrumb-item active">@lang('Edit Student')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <input type="hidden" id="record_id" value="{{ $student->id }}">
    <input type="hidden" id="table_name" value="student">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Edit Student')</h3>
                </div>
                <div class="card-body">
                    <form id="studentForm" class="form-material form-horizontal" action="{{ route('student.update', $student) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">@lang('Student Name') <b class="ambitious-crimson">*</b></label>
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                        </div>
                                        <input type="text" id="name" name="name" value="{{ old('name', $student->name) }}" class="form-control @error('name') is-invalid @enderror" placeholder="@lang('Student Name')" required>
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="department_id">@lang('Student Dept') <b class="ambitious-crimson">*</b></label>
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                        </div>
                                        <input type="number" id="department_id" name="department_id" value="{{ old('department_id', $student->department_id) }}" class="form-control @error('name') is-invalid @enderror" placeholder="@lang('Student Dept')" required>
                                        @error('department_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="teacher_id">@lang('Teacher')</label>
                            <select id="teacher_id" name="teacher_id" class="form-control">
                                <option value="">Select Teacher</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" {{ $student->teacher_id == $teacher->id ? 'selected' : '' }}>{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="course_id">@lang('Course')</label>
                            <select id="course_id" name="course_id" class="form-control">
                                <option value="">Select Course</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ $student->course_id == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">@lang('Address') <b class="ambitious-crimson">*</b></label>
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                        </div>
                                        <input type="text" id="address" name="address" value="{{ old('address', $student->address) }}" class="form-control @error('address') is-invalid @enderror" placeholder="@lang('Address')" required>
                                        @error('address')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="dob">@lang('Student Birthday') <b class="ambitious-crimson">*</b></label>
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                        </div>
                                        <input type="dob" id="dob" name="dob" value="{{ old('dob', $student->dob) }}" class="form-control @error('dob') is-invalid @enderror" placeholder="@lang('Student Birthday')" required>
                                        @error('dob')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 col-form-label"></label>
                                    <div class="col-md-8">
                                        <input type="submit" value="@lang('Update')" class="btn btn-outline btn-info btn-lg"/>
                                        <a href="{{ route('student.index') }}" class="btn btn-outline btn-warning btn-lg">@lang('Cancel')</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header bg-info">
            <h3 class="card-title">Upload Profile Picture</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="col-md-12">
                        <input id="profile_picture" name="profile_picture" type="file"
                            data-allowed-file-extensions="png jpg jpeg" data-max-file-size="2048K" />
                        <p>{{ __('Max Size: 2048kb, Allowed Format: png, jpg, jpeg') }}</p>
                        <br>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>@lang('Profile Picture')</th>
                                    <th>@lang('Uploaded By')</th>
                                    <th>@lang('Upload Date')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody id="profilePictureTableBody" class="fileTableBody"></tbody>

                            </tbody>
                        </table>
                    </div>
                    @error('profile_picture')
                        <div class="error ambitious-red">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header bg-info">
            <h3 class="card-title">Upload CNIC</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="col-md-12">
                        <input id="cnic_file" name="cnic_file[]" type="file" multiple
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
                            <tbody id="cnicFileTableBody" class="fileTableBody"></tbody>
                            <!-- CNIC files will be loaded here via AJAX -->
                            </tbody>
                        </table>
                    </div>
                    @error('cnic_file')
                        <div class="error ambitious-red">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header bg-info">
            <h3 class="card-title">Upload Insurance Documents</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="col-md-12">
                        <input id="insurance_card" name="insurance_card[]" type="file" multiple
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
                            <tbody id="insuranceCardTableBody" class="fileTableBody"></tbody>
                            <!-- Insurance files will be loaded here via AJAX -->
                            </tbody>
                        </table>
                    </div>
                    @error('insurance_card')
                        <div class="error ambitious-red">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header bg-info">
            <h3 class="card-title">Upload Other Documents</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="col-md-12">
                        <input id="other_files" name="other_files[]" type="file" multiple
                            data-allowed-file-extensions="png jpg jpeg pdf xml txt doc docx mp4"
                            data-max-file-size="2048K" />
                        <p>{{ __('Max Size: 2048kb, Allowed Format: png, jpg, jpeg, pdf, xml, txt, doc, docx, mp4') }}</p>
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
                            <tbody id="otherFilesTableBody" class="fileTableBody"></tbody>
                            <!-- Other files will be loaded here via AJAX -->
                            </tbody>
                        </table>
                    </div>
                    @error('other_files')
                        <div class="error ambitious-red">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>
    </div>






<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Function to fetch courses based on the selected teacher
        function fetchCourses(teacherId) {
            $.ajax({
                url: "{{ route('fetch-courses') }}",
                type: 'GET',
                data: { teacher_id: teacherId },
                dataType: 'json',
                success: function(data) {
                    $('#course_id').empty();
                    $.each(data, function(key, value) {
                        $('#course_id').append('<option value="' + key + '">' + value + '</option>');
                    });
                }
            });
        }

        // Load courses on page load based on the selected teacher
        var selectedTeacher = $('#teacher_id').val();
        if (selectedTeacher) {
            fetchCourses(selectedTeacher);
        }

        // Update courses when teacher dropdown value changes
        $('#teacher_id').on('change', function() {
            var teacherId = $(this).val();
            if (teacherId) {
                fetchCourses(teacherId);
            } else {
                $('#course_id').empty();
                $('#course_id').append('<option value="">Select Course</option>');
            }
        });
    });
</script>
<script>










@endsection


@push('footer')
    <script src="{{ asset('assets/js/quill.js') }}"></script>
    <script src="{{ asset('assets/js/custom/hospital-department/create.js') }}"></script>
@endpush

