@extends('layouts.layout')

@section('content')
<section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6 d-flex">
                    {{-- @can('lab-create') --}}
                    <h3 class="mr-2">
                        <a href="{{ route('labs.create') }}" class="btn btn-outline btn-info">
                            + @lang('Add Lab')
                        </a>
                        <span class="pull-right"></span>
                    </h3>
                        <h3>
                            <a href="{{ route('labs.index') }}" class="btn btn-outline btn-info">
                                <i class="fas fa-eye"></i>@lang('View All')
                            </a>
                            <span class="pull-right"></span>
                        </h3>
                    {{-- @endcan --}}
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('labs.index') }}">@lang('Lab')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('Edit Lab')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <input type="hidden" id="record_id" value="{{ $lab->id }}">
    <input type="hidden" id="table_name" value="lab">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="card-title d-inline">@lang('Edit Lab')</h3>
                            <h3 class="card-title d-inline ml-2">{{ old('lab_number', $lab->lab_number) }}</h3>
                        </div>
                    </div>
                </div>


                <div class="card-body">
                    <form id="labForm" class="form-material form-horizontal" action="{{ route('labs.update', $lab->id) }}"
                        method="POST" enctype="multipart/form-data" data-parsley-validate>
                      @csrf
                      @method('PUT')

                      <div class="row">

                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="Title">@lang('Lab Name') <b class="text-danger">*</b></label>
                                  <div class="form-group input-group mb-3">
                                      <div class="input-group-prepend">
                                          <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                      </div>
                                      <input type="text" id="Title" name="Title"
                                             value="{{ old('Title', $lab->title) }}"
                                             class="form-control @error('Title') is-invalid @enderror"
                                             placeholder="@lang('Lab Name')" required
                                             data-parsley-required-message="Please enter the lab name." >
                                  </div>
                                  @error('Title')
                                  <div class="invalid-feedback">
                                      {{ $message }}
                                  </div>
                                  @enderror
                              </div>
                          </div>

                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="PhoneNumber">@lang('Lab Phone')</label>
                                  <div class="form-group input-group mb-3">
                                      <div class="input-group-prepend">
                                          <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                      </div>
                                      <input type="text" id="PhoneNumber" name="PhoneNumber"
                                             value="{{ old('PhoneNumber', $lab->phone_no) }}"
                                             class="form-control @error('PhoneNumber') is-invalid @enderror"
                                             placeholder="@lang('Lab Phone')"
                                             data-parsley-type="digits" data-parsley-type-message="@lang('The phone number must be digits')">
                                  </div>
                                  @error('PhoneNumber')
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
                                  <label for="Description">@lang('Lab Description') <b class="text-danger">*</b></label>
                                  <div class="form-group input-group mb-3">
                                      <div class="input-group-prepend">
                                          <span class="input-group-text"><i class="fas fa-file"></i></span>
                                      </div>
                                      <textarea id="Description" name="Description" class="form-control @error('Description') is-invalid @enderror"
                                                rows="5" placeholder="@lang('Lab Description')" required
                                                data-parsley-required="@lang('The lab description field is required')">{{ old('Description', $lab->description) }}</textarea>
                                  </div>
                                  @error('Description')
                                  <div class="invalid-feedback">
                                      {{ $message }}
                                  </div>
                                  @enderror
                              </div>
                          </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Address">@lang('Lab Address')</label>
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-map-marker"></i></span>
                                        </div>
                                    <textarea id="Address" name="Address" class="form-control @error('Address') is-invalid @enderror" rows="5"
                                        placeholder="@lang('Lab     Address')">{{ old('Address', $lab->address) }}</textarea>
                                        </div>
                                    @error('Address')
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
                                    <div class="col-md-8 offset-md-0">
                                        <button type="submit" class="btn btn-outline btn-info btn-lg">
                                            {{ __('Update') }}
                                        </button>
                                        <a href="{{ route('labs.index') }}" class="btn btn-outline btn-warning btn-lg">
                                            {{ __('Cancel') }}
                                        </a>
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
            <h3 class="card-title">Upload Lab Files</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="col-md-12">
                        <input id="labs_files" name="labs_files[]" type="file" multiple
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
                            <tbody id="labsFilesTableBody" class="fileTableBody"></tbody>
                            <!-- Other files will be loaded here via AJAX -->
                            </tbody>
                        </table>
                    </div>
                    @error('labs_files')
                        <div class="error ambitious-red">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <script>
        var getFilesUrl = "{{ route('get-files', $lab->id) }}";
        var uploadFilesUrl = "{{ route('upload-file') }}";
        var deleteFilesUrl = "{{ route('delete-file') }}";
        var baseUrl = '{{ asset('') }}';
    </script>
@endsection
