@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6 d-flex">
                    <h3 class="mr-2">
                        <a href="{{ route('dd-procedures.create') }}" class="btn btn-outline btn-info">
                            + @lang('Add Procedure ')
                        </a>
                        <span class="pull-right"></span>
                    </h3>
                    <h3>
                        <a href="{{ route('dd-procedures.index') }}" class="btn btn-outline btn-info">
                            <i class="fas fa-eye"></i> @lang('View All')
                        </a>
                        <span class="pull-right"></span>
                    </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dd-procedures.index') }}">@lang('Procedure  ')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('Edit Procedure  ')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">Edit Procedure ({{ $ddProcedure->title }})</h3>
                </div>
                <div class="card-body">
                    <form id="departmentForm" class="form-material form-horizontal bg-custom"
                    action="{{ route('dd-procedures.update', $ddProcedure) }}" method="POST"
                    data-parsley-validate>
                  @csrf
                  @method('PUT')
                  <div class="row col-12 m-0 p-0">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label for="title">@lang('Title') <b class="ambitious-crimson">*</b></label>
                              <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                  </div>
                                  <input type="text" id="title" name="title"
                                         value="{{ old('title', $ddProcedure->title) }}"
                                         class="form-control @error('title') is-invalid @enderror"
                                         placeholder="@lang('Title')" required
                                         data-parsley-required-message="Please enter procedure title.">
                                  @error('title')
                                      <div class="invalid-feedback">
                                          {{ $message }}
                                      </div>
                                  @enderror
                              </div>
                          </div>
                      </div>
                      <div class="col-md-4">
                          <div class="form-group">
                              <label for="description">@lang('Description')</label>
                              <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="fas fa-file"></i></span>
                                  </div>
                                  <input type="text" id="description" name="description"
                                         value="{{ old('description', $ddProcedure->description) }}"
                                         class="form-control @error('description') is-invalid @enderror"
                                         placeholder="@lang('Description')">
                                  @error('description')
                                      <div class="invalid-feedback">
                                          {{ $message }}
                                      </div>
                                  @enderror
                              </div>
                          </div>
                      </div>
                      <div class="col-md-4">
                          <div class="form-group">
                              <label for="extra">@lang('Procedure Code') <b class="ambitious-crimson">*</b></label>
                              <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                                  </div>
                                  <input type="text" id="procedure_code" name="procedure_code"
                                         value="{{ old('procedure_code', $ddProcedure->procedure_code) }}"
                                         class="form-control @error('procedure_code') is-invalid @enderror"
                                         placeholder="@lang('Procedure Code')" required
                                         data-parsley-required-message="Please enter procedure code.">
                                  @error('procedure_code')
                                      <div class="invalid-feedback">
                                          {{ $message }}
                                      </div>
                                  @enderror
                              </div>
                          </div>
                      </div>
                  </div>

                  <div class="row col-12 m-0 p-0">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label for="info1">@lang('SN-No') <b class="ambitious-crimson">*</b></label>
                              <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                                  </div>
                                  <input type="text" id="sr_no" name="sr_no"
                                         value="{{ old('sr_no', $ddProcedure->sr_no) }}"
                                         class="form-control @error('sr_no') is-invalid @enderror"
                                         placeholder="@lang('SN-No')" required
                                         data-parsley-required-message="Please enter sr no.">
                                  @error('sr_no')
                                      <div class="invalid-feedback">
                                          {{ $message }}
                                      </div>
                                  @enderror
                              </div>
                          </div>
                      </div>
                      <div class="col-md-4">
                          <div class="form-group">
                              <label for="info2">@lang('Price') <b class="ambitious-crimson">*</b></label>
                              <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                  </div>
                                  <input type="text" id="price" name="price"
                                         value="{{ old('price', $ddProcedure->price) }}"
                                         class="form-control @error('price') is-invalid @enderror"
                                         placeholder="@lang('Price')" required
                                         data-parsley-required-message="Please enter price.""
                                         data-parsley-type="number"
                                         data-parsley-type-message="@lang('Price must be a number')">
                                  @error('price')
                                      <div class="invalid-feedback">
                                          {{ $message }}
                                      </div>
                                  @enderror
                              </div>
                          </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                            <label for="info3">@lang('Procedure') <b class="ambitious-crimson">*</b></label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-info"></i></span>
                                </div>
                                <select id="dd_procedure_id" name="dd_procedure_id"
                                        class="form-control @error('dd_procedure_id') is-invalid @enderror" required
                                        data-parsley-required-message="Please select procedure category.">
                                    @foreach ($ddProcedureCategories as $procedure)
                                        <option value="{{ $procedure->id }}"
                                            {{ old('dd_procedure_id', $ddProcedure->dd_procedure_id) == $procedure->id ? 'selected' : '' }}>
                                            {{ $procedure->title }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('dd_procedure_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row col-12 m-0 p-0">
                    <div class="col-12">
                        <div class="form-group pt-2">
                            <input type="submit" value="{{ __('Update') }}"
                                   class="btn btn-outline btn-info btn-lg" />
                            <a href="{{ route('dd-procedures.index') }}"
                               class="btn btn-outline btn-warning btn-lg">{{ __('Cancel') }}</a>
                        </div>
                    </div>
                </div>
            </form>
                </div>
            </div>
        </div>
    </div>

@endsection
