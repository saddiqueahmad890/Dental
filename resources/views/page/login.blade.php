<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/favicon.png') }}">
        <title>@lang('Log in') | {{ $ApplicationSetting->item_name }}</title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}" />
        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}" />
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('assets/css/adminlte.min.css') }}" />
        <!-- Ambitious CSS -->
        <link href="{{ asset('assets/css/frontend.css') }}" rel="stylesheet">
        @if(session('locale') == 'ar')
            <link href="{{ asset('assets/css/bootstrap-rtl.min.css') }}" rel="stylesheet">
        @else
            <link href="{{ asset('assets/plugins/alertifyjs/css/themes/bootstrap.min.css') }}" rel="stylesheet">
        @endif
        <style>

.invalid-feedback{
    position: absolute ;
    top: 40px;
    font-weight: bold;
}
.profile-user-img-custom {
    width: 173px !important;
    height: 173px !important;
}
.bg-custom{
    background: #f3f3f3;
    border: 1px solid #d9d1d1;
}


/* js validation message */
input.parsley-error {
    border-color: #ff4d4d;
    box-shadow: 0 0 5px #ff4d4d;
}

/* Style for the input field when it passes validation */
input.parsley-success {
    border-color: #28a745;
    box-shadow: 0 0 5px #28a745;
}

/* Style for the error messages */
.parsley-errors-list {
    list-style-type: none;
    padding: 0;
    margin: 5px 0 0;
    color: #ff4d4d;
    font-size: 0.875rem;
    position: absolute;
    top: 35px;
    /* Ensure the error message stays below the input field */
    display: block;
    /* Ensure the error message takes up full width below the field */
    width: 100%;
    /* Make sure the error message aligns with the input field width */
}

/* Style the error icon */
.parsley-errors-list li:before {
    content: "⚠ ";
    margin-right: 5px;
    font-size: 1rem;
}

/* Style the success icon for validated fields */
input.parsley-success+.input-group-prepend .input-group-text {
    color: #28a745;
}

input.parsley-error+.input-group-prepend .input-group-text {
    color: #ff4d4d;
}
        </style>
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <!-- /.login-logo -->
            <div class="card card-outline card-info">
                <div class="card-header bg-info text-center">
                    <a class="h1"><span class="identColor"><b>{{ $ApplicationSetting->item_name }}</b></span> clinic</a>
                </div>
                <div class="card-body">
                    <p class="login-box-msg m-0 p-0">Enter your email and password</p>
                    <br/>
                    {{-- <form action="{{ route('login') }}" method="post">
                        @csrf
                        <div class="input-group mb-3">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="@lang('Email')" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="input-group mb-3">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="@lang('Password')" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <div class="icheck-info">
                                    <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label for="remember">
                                        @if(session('locale') == 'ar')
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        @endif
                                        @lang('Remember Me')
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="social-auth-links text-center mt-2 mb-3">
                            <button type="submit" class="btn btn-block btn-info"> <i class="fas fa-sign-in-alt mr-2"></i> @lang('Log in')</button>
                        </div>
                    </form> --}}
                    <form action="{{ route('login') }}" method="post" data-parsley-validate>
                        @csrf
                        <div class="input-group mb-3">
                            <input id="email" type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}"
                                   placeholder="@lang('Email')"
                                   required
                                   data-parsley-required="true"
                                   data-parsley-type="email"
                                   data-parsley-required-message="@lang('Please enter valid email')"
                                   data-parsley-trigger="focusout">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="input-group mb-3 pt-2">
                            <input id="password" type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   name="password" placeholder="@lang('Password')"
                                   required
                                   data-parsley-required="true"
                                   data-parsley-required-message="@lang('Please enter your password')"
                                   data-parsley-trigger="focusout">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-8 ">
                                <div class="icheck-info">
                                    <input type="checkbox" id="remember" name="remember"
                                           {{ old('remember') ? 'checked' : '' }}>
                                    <label for="remember">
                                        @if(session('locale') == 'ar')
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        @endif
                                        @lang('Remember Me')
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="social-auth-links text-center mt-2 mb-3">
                            <button type="submit" class="btn btn-block btn-info">
                                <i class="fas fa-sign-in-alt mr-2"></i> @lang('Log in')
                            </button>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.login-box -->

        <!-- jQuery -->
        <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
        <!-- Bootstrap 4 -->
        @if(session('locale') == 'ar')
            <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
        @else
            <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        @endif
        <!-- AdminLTE App -->
        <script src="{{ asset('assets/js/adminlte.min.js') }}"></script>
        <!-- Custom Js -->
        <script src="{{ asset('assets/js/custom/login.js') }}"></script>
        <!-- validation  -->
        <script src="{{ URL::asset('assets\js\parsely.min.js') }}"></script>

    </body>
</html>
