@extends('layouts.layout')
@section('one_page_css')
    <link href="{{ asset('assets/css/quill.snow.css') }}" rel="stylesheet">
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('student.index') }}">@lang('Students')</a></li>
                        <li class="breadcrumb-item active">@lang('Add Student')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Add Student')</h3>
                </div>
                <div class="card-body">
                    <form id="StudentForm" class="form-material form-horizontal" action="{{ route('student.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">@lang('Student Name') <b class="ambitious-crimson">*</b></label>
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                        </div>
                                        <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="@lang('Student Name')" required>
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
                                    <label for="department_id">@lang('Student Department') <b class="ambitious-crimson">*</b></label>
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                        </div>
                                        <input type="number" id="department_id" name="department_id" value="{{ old('department_id') }}" class="form-control @error('department_id') is-invalid @enderror" placeholder="@lang('Department ID')" required>
                                        @error('department_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="teacher_id">@lang('Select Teacher') <b class="ambitious-crimson">*</b></label>
                                    <select name="teacher_id" id="teacher_id" class="form-control custom-width-100 @error('teacher_id') is-invalid @enderror" required>
                                        <option value="">--@lang('Select')--</option>
                                        @foreach($teachers as $teacher)
                                            <option value="{{ $teacher->id }}" @if($teacher->id == old('id')) selected @endif>{{ $teacher->id.'. '.$teacher->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="course_id">@lang('Student Course') <b class="ambitious-crimson">*</b></label>
                                    <select id="course_id" name="course_id" class="form-control @error('course_id') is-invalid @enderror" required>
                                        <option value="">Select Course</option>
                                    </select>
                                    @error('course_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">@lang('Student Address') <b class="ambitious-crimson">*</b></label>
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                        </div>
                                        <input type="text" id="address" name="address" value="{{ old('address') }}" class="form-control @error('address') is-invalid @enderror" placeholder="@lang('Student Address')" required>
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
                                        <input type="date" id="dob" name="dob" value="{{ old('dob') }}" class="form-control @error('dob') is-invalid @enderror" placeholder="@lang('Student Dob')" required>
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
                                        <input type="submit" value="@lang('Submit')" class="btn btn-outline btn-info btn-lg"/>
                                        <a href="{{ route('student.index') }}" class="btn btn-outline btn-warning btn-lg">@lang('Cancel')</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="container mt-5">
                        <div class="row">
                            <div class="col-md-12">
                                <label name="file" class="col-form-label"><h4>{{ __('Upload your file here') }}</h4></label>
                                <div style="display: flex; align-items: center; margin-bottom: 10px;">
                                    <input id="file" class="" name="files[]" type="file" data-allowed-file-extensions="png jpg jpeg pdf" data-max-file-size="2024K" multiple style="width: 200px; height: 38px; margin-right: 20px;" />

                                  
                                    {{-- <input type="text" name="input1" id="file1" class="form-control" style="width: 200px; height: 38px;"> --}}
                                   
                                </div>
                                <p>{{ __('Max Size: 1000kb, Allowed Format: png, jpg, jpeg') }}</p>
                                @error('file')
                                    <div style="color: red;">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <table border="1" id="filetable">
                        <tr>
                            <th>File Name</th>
                            <th>Delete</th>
                            <th>Download</th>
                        </tr>
                        <!-- Initial empty row (optional) -->
                        <tr>
                            <td colspan="3">No files uploaded yet.</td>
                        </tr>
                    </table>
                      
            </div>
        </div>

    
   

  

    
        <script>

            $(document).ready(function() {
                $(document).on('change', '#file', function() {
                    var files = $('#file')[0].files;
                    var formData = new FormData();
                    for (var i = 0; i < files.length; i++) {
                        formData.append('files[]', files[i]);
                    }
            
                    $.ajax({
                        url: '#',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                alert('File uploaded successfully!');
                                var htmlContent = ''; // Initialize empty string for table rows
                                $.each(response.files, function(index, item) {
                                    htmlContent += `
                                        <tr>
                                            <td>${item}</td>
                                            <td>
                                                <form method="POST" action="#">
                                                    @csrf
                                                    <input type="hidden" name="value1" id="name1" value="${item}">
                                                    <button type="submit" class="btn btn-primary">Download</button>
                                                </form>
                                            </td>
                                            <td>
                                                <button class="btn btn-danger delete-btn" data-item="${item}">Delete</button>
                                            </td>
                                        </tr>
                                    `;
                                });
            
                                // Update the HTML content of #filetable with new rows
                                $('#filetable').html(htmlContent);
                            } else {
                                alert('File upload failed!');
                            }
                        },
                        error: function(response) {
                            alert('An error occurred while uploading the file.');
                        }
                    });
                });
            
                // Add event listener for delete button clicks
                $(document).on('click', '.delete-btn', function() {
                    var fileName = $(this).data('item');
                    var deleteButton = $(this); 
                    // AJAX request to delete the file
                    $.ajax({
                        url: '#', // Replace with your delete route
                        type: 'DELETE',
                        data: {
                            filename: fileName
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                alert('File deleted successfully!');
                                
                                // Optionally remove the deleted file row from the table
                                // $(this).closest('tr').remove();
                                deleteButton.closest('tr').remove();
                            } else {
                                alert('Failed to delete file.');
                            }
                        },
                        error: function(response) {
                            alert('An error occurred while deleting the file.');
                        }
                    });
                });
            
            });
            
            </script>
            


@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#teacher_id').on('change', function() {
            var teacherId = $(this).val();
            if (teacherId) {
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
            } else {
                $('#course_id').empty();
                $('#course_id').append('<option value="">Select Course</option>');
            }
        });
    });
</script>


@push('footer')
    <script src="{{ asset('assets/js/quill.js') }}"></script>
    <script src="{{ asset('assets/js/custom/hospital-department/create.js') }}"></script>
@endpush
