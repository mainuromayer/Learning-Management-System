@extends('frontend.main')

@section('title')
Login
@endsection

@section('content')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Login -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <a href="/" class="app-brand-link gap-2">
                                <span class="app-brand-logo demo">

                                </span>

                                {{--                                <span class="demo text-body fw-bold h4"> --}}
                                {{--                                    <img src="{{ asset('assets/img/icons/logo.png') }}" alt="" height="" width="260"> --}}
                                {{--                                </span> --}}
                                <a href="" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
                                    <h2 class="m-0 text-primary"><i class="fa fa-book me-3"></i>GUB</h2>
                                </a>
                            </a>
                        </div>
                        <!-- /Logo -->

                        {!! Form::open([
                            'route' => 'login.check',
                            'method' => 'post',
                            'id' => 'form_id',
                            'enctype' => 'multipart/form-data',
                            'files' => 'true',
                            'role' => 'form',
                        ]) !!}
                        <div class="mb-3">
                            <div class=" {{ $errors->has('name') ? 'has-error' : '' }}">
                                {!! Form::label('email', 'Email', ['class' => 'col-md-12 form-label required-star']) !!}
                                <div class="col-md-12">
                                    {!! Form::text('email', old('eamil'), [
                                        'class' => 'form-control required',
                                        'placeholder' => 'Enter your email',
                                        'autofocus' => 'true',
                                    ]) !!}
                                    {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>

                        <div class=" mb-3 form-password-toggle  {{ $errors->has('password') ? 'has-error' : '' }}">
                            <div class="d-flex justify-content-between">
                                {!! Form::label('password', 'Password', ['class' => 'form-label required-star']) !!}
                                <a href="auth-forgot-password-basic.html">
                                    <small>Forgot Password?</small>
                                </a>
                            </div>

                            <div class="input-group">
                                {!! Form::password('password', ['class' => 'form-control required', 'placeholder' => '']) !!}
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                            {!! $errors->first('password', '<span class="help-block">:message</span>') !!}

                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember-me" />
                                <label class="form-check-label" for="remember-me"> Remember Me </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                        </div>
                        {!! form::close() !!}

                        <p class="text-center">
                            <span>New on our platform?</span>
                            <a href="{{ url('register') }}">
                                <span>Register Now</span>
                            </a>
                        </p>
                    </div>
                </div>
                <!-- /Login -->
            </div>
        </div>
    </div>
@endsection
