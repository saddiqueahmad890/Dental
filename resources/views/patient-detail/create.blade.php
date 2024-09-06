@extends('layouts.layout')
@section('content')
    <style>
        .email-label {
            display: inline-block;
            width: 100%;
            margin-bottom: 0.5rem;
        }

        .input-group {
            position: relative;
        }

        .email-checkbox {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
        }
    </style>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3><a href="{{ route('patient-details.index') }}" class="btn btn-outline btn-info">
                            <i class="fas fa-eye"></i> @lang('View All')</a>
                        <span class="pull-right"></span>
                    </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('patient-details.index') }}">@lang('Patient')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('Add Patient')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">@lang('Add Patient')</h3>
                </div>
                <div class="card-body">
                    <form id="patientForm" class="form-material form-horizontal bg-custom"
                    action="{{ route('patient-details.store') }}" method="POST" enctype="multipart/form-data" data-parsley-validate>
                  @csrf
                  <div class="row col-12 p-0 m-0">
                      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3">
                          <div class="form-group">
                              <label for="name">@lang('Name') <b class="ambitious-crimson">*</b></label>
                              <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                  </div>
                                  <input type="text" id="name" name="name" value="{{ old('name') }}"
                                         class="form-control @error('name') is-invalid @enderror"
                                         placeholder="@lang('John Doe')" required data-parsley-required="true"
                                         data-parsley-required-message="@lang("Please enter patient's name")">
                                  @error('name')
                                  <div class="invalid-feedback">
                                      {{ $message }}
                                  </div>
                                  @enderror
                              </div>
                          </div>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3">
                          <div class="form-group">
                              <label for="phone">@lang('Phone') <b class="ambitious-crimson">*</b></label>
                              <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                  </div>
                                  <input type="number" id="phone" name="phone" value="{{ old('phone') }}"
                                         class="form-control @error('phone') is-invalid @enderror"
                                         placeholder="@lang('03375544887')" required data-parsley-required="true"
                                         data-parsley-required-message="@lang('Phone is required')"
                                         data-parsley-type="number" data-parsley-type-message="@lang('Invalid phone number')">
                                  @error('phone')
                                  <div class="invalid-feedback">
                                      {{ $message }}
                                  </div>
                                  @enderror
                              </div>
                          </div>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3">
                          <div class="form-group">
                              <label for="email" class="email-label">
                                  @lang('Email') <b class="ambitious-crimson">*</b>
                              </label>
                              <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="fas fa-at"></i></span>
                                  </div>
                                  <input type="email" id="email" name="email" value="{{ old('email') }}"
                                         class="form-control @error('email') is-invalid @enderror"
                                         placeholder="@lang('example@gmail.com')" required data-parsley-required="true"
                                         data-parsley-required-message="@lang('Email is required')"
                                         data-parsley-type="email" data-parsley-type-message="@lang('Invalid email address')">
                                  <input style="position: absolute;top: -19px;right: 10px;" type="checkbox"
                                         class="form-check-input email-checkbox" id="noEmailCheckbox">
                                  <label style="position: absolute;top: -30px;right: 30px;" class="form-check-label"
                                         for="noEmailCheckbox">@lang('No Email')</label>
                                  @error('email')
                                  <div class="invalid-feedback">
                                      {{ $message }}
                                  </div>
                                  @enderror
                              </div>
                          </div>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3">
                          <div class="form-group">
                              <label for="gender">@lang('Gender')</label>
                              <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                  </div>
                                  <select name="gender" class="form-control @error('gender') is-invalid @enderror"
                                          id="gender" data-parsley-required="true" data-parsley-required-message="@lang('Gender is required')">
                                      <option value="">--@lang('Select')--</option>
                                      <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>@lang('Male')</option>
                                      <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>@lang('Female')</option>
                                  </select>
                                  @error('gender')
                                  <div class="invalid-feedback">
                                      {{ $message }}
                                  </div>
                                  @enderror
                              </div>
                          </div>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3">
                          <div class="form-group">
                              <label for="blood_group">@lang('Blood Group')</label>
                              <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="fas fa-heartbeat"></i></span>
                                  </div>
                                  <select name="blood_group"
                                          class="form-control select2 @error('blood_group') is-invalid @enderror"
                                          id="blood_group">
                                      <option value="" {{ old('blood_group') ? '' : 'selected' }}>Select Blood Group</option>
                                      @foreach ($bloodGroups as $bloodGroup)
                                          <option value="{{ $bloodGroup->id }}"
                                                  {{ old('blood_group') == $bloodGroup->id ? 'selected' : '' }}>
                                              {{ $bloodGroup->name }}
                                          </option>
                                      @endforeach
                                  </select>
                                  @error('blood_group')
                                  <div class="invalid-feedback">
                                      {{ $message }}
                                  </div>
                                  @enderror
                              </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3">
                                <div class="form-group">
                                    <label for="date_of_birth">@lang('Date of Birth')</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-check"></i></span>
                                        </div>
                                        <input type="text" name="date_of_birth" id="date_of_birth"
                                            value="{{ old('date_of_birth') }}"
                                            class="form-control flatpickr @error('date_of_birth') is-invalid @enderror"
                                            placeholder="@lang('1990-05-04')" value="{{ old('date_of_birth') }}">
                                        @error('date_of_birth')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3">
                                <div class="form-group">
                                    <label for="marital_status">@lang('Marital Status')</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-heart"></i></span>
                                        </div>
                                        <select
                                            class="form-control select2 ambitious-form-loading @error('marital_status') is-invalid @enderror"
                                            name="marital_status" id="marital_status">
                                            <option value="" {{ old('marital_status') ? '' : 'selected' }}>Select
                                            </option>
                                            @foreach ($maritalStatuses as $maritalStatus)
                                                <option value="{{ $maritalStatus->id }}"
                                                    {{ old('marital_status') == $maritalStatus->id ? 'selected' : '' }}>
                                                    {{ $maritalStatus->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('marital_status')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3">



                                <div class="form-group">
                                    <label for="cnic">@lang('CNIC / Passport') <b class="ambitious-crimson">*</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                        </div>
                                        <input type="text" id="cnic" name="cnic" class="form-control"
                                            value="{{ old('cnic') }}" placeholder="@lang('11111-1111111-1')" required>
                                    </div>
                                </div>


                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3">
                                <div class="form-group">
                                    <label for="credit_balance">@lang('Credit Balance')</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                        </div>
                                        <input type="number" name="credit_balance" id="credit_balance"
                                            class="form-control @error('credit_balance') is-invalid @enderror"
                                            value="{{ old('credit_balance') }}" placeholder="@lang('15000')">
                                        @error('credit_balance')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3">
                                <div class="form-group">
                                    <label for="insurance_provider_id">@lang('Insurance Provider')</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-shield-alt"></i></span>
                                        </div>
                                        <select
                                            class="select2-custom form-control select2 ambitious-form-loading @error('insurance_provider_id') is-invalid @enderror"
                                            name="insurance_provider_id" id="insurance_provider_id">
                                            <option value="" {{ old('insurance_provider_id') ? '' : ' selected' }}>
                                                Select Provider</option>
                                            @foreach ($insuranceProviders as $insuranceProvider)
                                                <option value="{{ $insuranceProvider->id }}"
                                                    {{ old('insurance_provider_id') == $insuranceProvider->id ? 'selected' : '' }}>
                                                    {{ $insuranceProvider->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('insurance_provider_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3">
                                <div class="form-group">
                                    <label for="area">@lang('Area')</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i
                                                    class="fa fa-solid fa-map-marker"></i></span>
                                        </div>
                                        <input type="text" name="area" id="area" value="{{ old('area') }}"
                                            class="form-control @error('area') is-invalid @enderror" rows="1"
                                            placeholder="@lang('i8 Markaz')"{{ old('area') }} />
                                        @error('area')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3">
                                <div class="form-group">
                                    <label for="city">@lang('City')</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i
                                                    class="fa fa-solid fa-map-marker"></i></span>
                                        </div>
                                        <input type="text" name="city" id="city" value="{{ old('city') }}"
                                            class="form-control @error('city') is-invalid @enderror" rows="1"
                                            placeholder="@lang('Islamabad')"{{ old('city') }} />
                                        @error('city')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3">
                                <div class="form-group">
                                    <label for="address">@lang('Address')</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i
                                                    class="fa fa-solid fa-map-marker"></i></span>
                                        </div>
                                        <input type="text" name="address" id="address"
                                            value="{{ old('address') }}"
                                            class="form-control @error('address') is-invalid @enderror" rows="1"
                                            placeholder="@lang('House 35, Street 66, i8 markaz, Islamabad')"{{ old('address') }} />
                                        @error('address')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3">
                                <div class="form-group">
                                    <label for="status">@lang('Status') <b class="ambitious-crimson">*</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-bell"></i></span>
                                        </div>
                                        <select
                                            class="form-control ambitious-form-loading @error('status') is-invalid @enderror"
                                            required name="status" id="status">
                                            <option value="1" {{ old('status') === '1' ? 'selected' : '' }}>
                                                @lang('Active')</option>
                                            <option value="0" {{ old('status') === '0' ? 'selected' : '' }}>
                                                @lang('Inactive')</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div> --}}
                            <input type="hidden" id="password" name="password" value="12345678" required>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3">
                                <div class="form-group">
                                    <label for="other_details">Other Details</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-file"></i></span>
                                        </div>
                                        <textarea rows="1" type="text" id="other-details" name="other_details" value="{{ old('other_details') }}"
                                            class="form-control" placeholder="Additional details..."></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3">
                                <div class="form-group">
                                    <label for="enquirysource">@lang('Where did you hear about us?')</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-heartbeat"></i></span>
                                        </div>
                                        <select name="enquirysource"
                                            class="form-control select2 @error('enquirysource') is-invalid @enderror"
                                            id="enquirysource">
                                            <option value="" disabled {{ old('enquirysource') ? '' : 'selected' }}>
                                                Select Source</option>
                                            @foreach ($enquirysource as $enquiry)
                                                <option value="{{ $enquiry->id }}"
                                                    {{ old('enquirysource') == $enquiry->id ? 'selected' : '' }}>
                                                    {{ $enquiry->source_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('enquirysource')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>

                            <div class="form-group col-12 p-0 m-0">
                                <label class="col-md-3 col-form-label"></label>
                                <div class="col-md-8">
                                    <input type="submit" value="{{ __('Submit') }}"
                                        class="btn btn-outline btn-info btn-lg mb-2" />
                                    <a href="{{ route('patient-details.index') }}"
                                        class="btn btn-outline btn-warning btn-lg mb-2">{{ __('Cancel') }}</a>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('noEmailCheckbox').addEventListener('change', function() {
            var emailField = document.getElementById('email');
            var phoneField = document.getElementById('phone');

            if (this.checked) {
                emailField.value = 'noemail' + phoneField.value + '@gmail.com';
                emailField.setAttribute('readonly', true);
            } else {
                emailField.value = '';
                emailField.removeAttribute('readonly');
            }
        });
    </script>
@endsection
